<?php

namespace App\Http\Controllers;

use App\Models\Notification;
use Illuminate\Http\Request;
use Kreait\Firebase\Messaging\CloudMessage;
use Kreait\Firebase\Factory;
use App\Models\User;
use App\Models\Post;
use App\Traits\FirebaseNotificationTrait;

class PostController extends Controller
{
    // Sử dụng Trait FirebaseNotificationTrait
    use FirebaseNotificationTrait;

    public function detail($postId)
    {
        // Lấy bài viết theo postId
        $post = Post::find($postId);
        // Lấy userId từ bài viết
        $userId = $post->user_id;
        $postNotification=Notification::where('type','read_post')->first();

        if(!$postNotification){
            // Tiêu đề và nội dung thông báo
        $title = "Thông báo mới";
        $message = "Có ngườ đã đọc bài viết mới của bạn.";
        }
        else{
            $title=$postNotification->title;
            $message=$postNotification->message;
        }
        // Gọi phương thức từ Trait để gửi thông báo
        $result = $this->sendNotification($userId, $title, $message);


        // Trả về view chi tiết bài viết
        return view('post.detail', compact('post'));
    }
}
