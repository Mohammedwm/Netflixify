<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Movie extends Model
{
    protected $fillable = ['name','description','path','rating','year','poster','image','percent'];


    protected $appends = ['poster_path' , 'image_path' , 'is_favored'];

    public function getPosterPathAttribute()
    {
        return Storage::url('images/'.$this->poster);
    }// end of getPosterPathAttribute

    public function getImagePathAttribute()
    {
        return Storage::url('images/'.$this->image);
    }// end of getImagePathAttribute


    public function getIsFavoredAttribute(Type $var = null)
    {
        if(auth()->user()){
            return (bool)$this->users()->where('user_id' , auth()->user()->id)->count();
        }

        return false;
    }

    public function scopeWhenCategory($query , $category)
    {
        return $query->when($category , function ($q) use ($category){
            return $q->whereHas('categories',function ($qu) use ($category){
                return $qu->whereIn('category_id' , (array) $category)
                    ->orWhereIn('name' , (array)$category);
            });
        });
    }

    public function scopeWhenFavorite($query , $favorite)
    {
        return $query->when($favorite , function ($q) {
            return $q->whereHas('users',function ($qu){
                return $qu->where('user_id' ,  auth()->user()->id);
            });
        });
    }

    // relations --------------------------
    public function categories(){
        return $this->belongsToMany(Category::class , 'movie_category');
    }

    public function users(){
        return $this->belongsToMany(User::class , 'user_movie');
    }
}
