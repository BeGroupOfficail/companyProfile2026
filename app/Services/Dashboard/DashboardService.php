<?php
namespace App\Services\Dashboard;

use App\Models\Dashboard\About\AboutValue;
use App\Models\Dashboard\Album\Album;
use App\Models\Dashboard\Blog\Blog;
use App\Models\Dashboard\Blog\BlogCategory;
use App\Models\Dashboard\Client\Client;
use App\Models\Dashboard\Menu\Menu;
use App\Models\Dashboard\Menu\MenuItem;
use App\Models\Dashboard\Page\Page;
use App\Models\Dashboard\Project\Project;
use App\Models\Dashboard\Service\Service;
use App\Models\Dashboard\Slider\Slider;
use App\Models\Dashboard\Testimonial\Testimonial;
use App\Models\Dashboard\WebsiteStatistics\WebsiteStatistics;
use App\Models\User;
use App\Models\Website\StudentTraining;

class DashboardService
{
    public function changeStatus($model, $ids)
    {
        foreach ($ids as $id) {
            if($id === 'on') continue;

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

            if ($model == 'website_statistics') {
                $updatedModel = WebsiteStatistics::find($id);
            }

            if ($model == 'projects') {
                $updatedModel = Project::find($id);
            }

            if ($model == 'about_values') {
                $updatedModel = AboutValue::find($id);
            }


            if ($updatedModel) {
                $newStatus = $updatedModel->status == 'published' ? 'inactive' : 'published';
                $updatedModel->update(['status' => $newStatus]);
            }
        }
        return ['newStatus' => $newStatus];
    }

}
