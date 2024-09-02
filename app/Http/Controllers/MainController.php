<?php

namespace App\Http\Controllers;

use App\Models\QuoteCategory;
use App\Models\TermCategory;
use App\Models\VideoCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;

class MainController extends Controller
{
    public function home(Request $request)
    {
        $rootCategories = $this->getCombinedCategoriesTree();
        $this->addSupportedTypeLinksToCategories($rootCategories);

        return view('front.pages.home', compact('rootCategories'));
    }

    /**
     * Combine all categories and return a unique collection of categories.
     *
     * @return \Illuminate\Support\Collection
     */
    private function getCombinedCategoriesTree(): Collection
    {
        $categories = new Collection();

        $categories = $categories->concat(QuoteCategory::get()->toTree());
        $categories = $categories->concat(TermCategory::get()->toTree());
        $categories = $categories->concat(VideoCategory::get()->toTree());

        return $categories->unique('name');
    }

    /**
     * Add supported type links to each category and its children.
     *
     * @param  \Illuminate\Support\Collection  $categories
     * @return void
     */
    private function addSupportedTypeLinksToCategories(Collection $categories): void
    {
        $categories->each(function ($category) {
            $category->supported_type_links = $this->getSupportedTypeLinksForCategory($category);

            if ($category->children) {
                $this->addSupportedTypeLinksToCategories($category->children);
            }
        });
    }

    /**
     * Get supported type links for a specific category.
     *
     * @param  \Illuminate\Database\Eloquent\Model  $category
     * @return array
     */
    private function getSupportedTypeLinksForCategory($category): array
    {
        $links = [];

        if (QuoteCategory::where('name', $category->name)->exists()) {
            $links[] = [
                'label' => 'Цитаты и Афоризмы',
                'href' => route('quotes.category', $category->slug)
            ];
        }

        if (TermCategory::where('name', $category->name)->exists()) {
            $links[] = [
                'label' => 'Термины',
                'href' => route('terms.category', $category->slug)
            ];
        }

        if (VideoCategory::where('name', $category->name)->exists()) {
            $links[] = [
                'label' => 'Видео',
                'href' => route('videos.category', $category->slug)
            ];
        }

        // Avoid duplicate dictionary links
        if (TermCategory::where('name', $category->name)->exists() && !array_key_exists('Словарь', $links)) {
            $links[] = [
                'label' => 'Словарь',
                'href' => route('vocabulary.category', $category->slug)
            ];
        }

        return $links;
    }
}
