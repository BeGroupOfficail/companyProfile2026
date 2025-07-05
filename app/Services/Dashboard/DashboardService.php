<?php
namespace App\Services\Dashboard;

use App\Models\Dashboard\About\AboutValue;
use App\Models\Dashboard\Album\Album;
use App\Models\Dashboard\Blog\Blog;
use App\Models\Dashboard\Blog\BlogCategory;
use App\Models\Dashboard\Center\Center;
use App\Models\Dashboard\Center\CenterHall;
use App\Models\Dashboard\Client\Client;
use App\Models\Dashboard\Course\Course;
use App\Models\Dashboard\Course\Field;
use App\Models\Dashboard\Course\Survey;
use App\Models\Dashboard\Destination\Destination;
use App\Models\Dashboard\Menu\Menu;
use App\Models\Dashboard\Menu\MenuItem;
use App\Models\Dashboard\Page\Page;
use App\Models\Dashboard\Service;
use App\Models\Dashboard\Slider\Slider;
use App\Models\Dashboard\Testimonial\Testimonial;
use App\Models\Dashboard\Tour\Tour;
use App\Models\Dashboard\Training;
use App\Models\StudentTraining;
use App\Models\User;

class DashboardService
{
    public function changeStatus($model,$ids)
    {
        foreach ($ids as $id) {


            if ($model == 'services') {
                $updatedModel = Service::find($id);
            }

            if ($model == 'albums') {
                $updatedModel = Album::find($id);
            }

            if ($model == 'menus') {
                $updatedModel = Menu::find($id);
            }

            if ($model == 'menu_items') {
                $updatedModel = MenuItem::find($id);
            }

            if ($model == 'pages') {
                $updatedModel = Page::find($id);
            }

            if ($model == 'sliders') {
                $updatedModel = Slider::find($id);
            }

            if ($model == 'blogs') {
                $updatedModel = Blog::find($id);
            }

            if ($model == 'blog_categories') {
                $updatedModel = BlogCategory::find($id);
            }

            if ($model == 'clients') {
                $updatedModel = Client::find($id);
            }

            if ($model == 'testimonials') {
                $updatedModel = Testimonial::find($id);
            }

            if ($model == 'about_values') {
                $updatedModel = AboutValue::find($id);
            }

            if ($model == 'destinations') {
                $updatedModel = Destination::find($id);
            }

            if ($model == 'tours') {
                $updatedModel = Tour::find($id);
            }

            if ($model == 'instructors') {
                $updatedModel = User::find($id);
                $newStatus = $updatedModel->status== "inactive"?"active":"inactive";
                $updatedModel->update(['status' => $newStatus]);
                return ['newStatus'=>$newStatus];
            }

            if ($updatedModel) {
                $newStatus = $updatedModel->status == 'published' ? 'inactive' : 'published';
                $updatedModel->update(['status' => $newStatus]);
            }
        }
        return ['newStatus'=>$newStatus];
    }

    public function dashboardStatistics()
    {
        $superAdminsCount = User::where('job_role','super_admin')->where('status','active')->count();


        return [$superAdminsCount];
    }
}
