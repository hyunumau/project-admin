<?php

namespace App\Services;

use App\Models\Article;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class ArticleService
{
    protected $article;

    public function __construct(Article $article)
    {
        $this->article = $article;
    }

    /**
     * hhh
     *
     * @return \Illuminate\Pagination\LengthAwarePaginator|\Illuminate\Support\Collection
     */
    public function getList(array $filter = [])
    {
        $articleTable = $this->article->getTable();

        $query = $this->article->join('users as u', 'u.id', '=', "{$articleTable}.author")
            ->select("{$articleTable}.*", 'u.name as authorInfo_name');

        if ($categories = Arr::get($filter, 'categories')) {
            $query->whereHas('categories', function ($query) use ($categories) {
                $query->whereIn('id', $categories);
            });
        }

        return $query->filter($filter)
            ->searchAll($filter, [ "{$articleTable}.id", 'caption', 'u.name'])
            ->getWithPaginate($filter);
    }

    public function create($data)
    {
        DB::beginTransaction();
        try {
            $data['author'] = auth()->user()->id;
            $data['publish'] = 0;
            $fileName = $this->handleFileUpload(Arr::get($data, 'image'));
            $data['image'] = $fileName;

            $article = $this->article->fill($data);

            $article->save();

            if (isset($data['categories'])) {
                $article->categories()->sync($data['categories']);
            }
            if (isset($data['tags'])) {
                $article->tags()->sync($data['tags']);
            }



            DB::commit();

            return $article;
        } catch (\Exception $e) {
            DB::rollBack();

            Log::error($e->getMessage());

            return null;
        }
    }


    /**
     * @param   \Illuminate\Http\UploadedFile  $file
     */
    public function handleFileUpload(?UploadedFile $file)
    {
        if (is_null($file)) {
            return null;
        }

        $fileName = time() . "-" . $file->getClientOriginalName();
        $file->storeAs('public', $fileName);

        return $fileName;
    }

    public function update($data, $article)
    {
        DB::beginTransaction();
        try {
            $fileName = $this->handleFileUpload(Arr::get($data, 'image'));

            if (empty($fileName)) {
                $data['image'] = $article->image;
            } else {
                unlink(public_path($article->image_url));
                $data['image'] = $fileName;
            }

            if (isset($data['categories'])) {
                $article->categories()->sync($data['categories']);
            }

            if (isset($data['tags'])) {
                $article->tags()->sync($data['tags']);
            }

            $article->fill($data)->save();

            DB::commit();

            return $article;
        } catch (\Exception $e) {
            DB::rollBack();

            Log::error($e->getMessage());

            return null;
        }
    }

    public function delete($article)
    {
        $article->delete();
    }
}
