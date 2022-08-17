<?php

namespace App\Traits;

use App\Models\User;
use App\Models\PostMedia;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\File;
use Intervention\Image\Facades\Image;

trait ImagesManagerTrait
{
    protected function UserImageUploade($image, $oldImage, $username)
    {
        if($image){
            if($oldImage != ''){
                if(File::exists('/assets/users/' . $oldImage)){
                    unlink('/assets/users/' . $oldImage);
                }
            }
            $filename = Str::slug($username) . '.' . $image->getClientOriginalExtension();
            $path = public_path('assets/users/' . $filename);
            Image::make($image->getRealPath())->resize(300, 300, function($constraint){
                $constraint->aspectRatio();
            })->save($path, 100);
            return $filename;
        }
    }
    //$this->UserImageUploade($request->file('user_image'), auth()->user()->user_image, $user->username);
    
    protected function createUserImageUploade($image, $person)
    {
        $filename = Str::slug($person) . '.' . $image->getClientOriginalExtension();
        $path = public_path('assets/users/' . $filename);
        Image::make($image->getRealPath())->resize(300, 300, function($constraint){
            $constraint->aspectRatio();
        })->save($path, 100);
        return $filename;
    }
    //$this->createUserImageUploade($request->file('user_image'), auth()->user()->user_image);

    protected function destroyUserMedia($user)
    {
        if($user->user_image != ''){
            if(File::exists('assets/users/' . $user->user_image)){
                unlink('assets/users/' . $user->user_image);
            }
        }
    }

    protected function destroyUserImage($userId)
    {
        $user = User::whereId($userId)->first();

        if($user){
            if(File::exists('assets/users/' . $user->user_image)){
                unlink('assets/users/' . $user->user_image);
            }
            $user->user_image = null;
            $user->save();

            return 'true';
        }
        return 'false';
    }
    //return $this->destroyUserImage($request->user_id);
    
    protected function PostImagesUploade($images, $post)
    {
        if($images && count($images) > 0){
            $i = 1;
            foreach($images as $file){
                $filename = $post->slug . '-' . time() . '-' . $i . $file->getClientOriginalExtension();
                $path = public_path('assets/posts/' . $filename);
                Image::make($file->getRealPath())->resize(800, null, function($constraint){
                    $constraint->aspectRatio();
                })->save($path, 100);
                $post->media()->create([
                    'file_name' => $filename,
                    'file_size' => $file->getSize(),
                    'file_type' => $file->getMimeType(),
                ]);
                $i++;
            }
        }
    }
    //$this->PostImagesUploade($request->images, $post);

    protected function destroyPostImage($media_id)
    {
        $media = PostMedia::whereId($media_id)->first();
        if($media){
            if(File::exists('assets/posts/' . $media->file_name)){
                unlink('assets/posts/' . $media->file_name);
            }
            $media->delete();
            return true;
        }
        return false;   
    }
    //return $this->destroyPostImage($media_id);

    protected function destroyPostMedia($post)
    {
        if($post->media->count() > 0){
            foreach($post->media as $media){
                if(File::exists('assets/posts/' . $media->file_name)){
                    unlink('assets/posts/' . $media->file_name);
                }
            }
        }
    }
    //$this->destroyPostMedia($post);
}