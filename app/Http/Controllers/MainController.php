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

        // Add supported_type_links for each concrete categories
        $nestedCategoriesArray = $this->getCategoriesAsNestedArray();
        $this->addSupportedTypeLinksToCategories($rootCategories, $nestedCategoriesArray);

        return view('front.pages.home', compact('rootCategories'));
    }

    public function aboutUs()
    {
        return view('front.pages.about-us');
    }

    public function contacts()
    {
        return view('front.pages.contacts');
    }

    public function privacyPolicy()
    {
        return view('front.pages.privacy-policy');
    }

    public function termsOfUse()
    {
        return view('front.pages.terms-of-use');
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

    private function getCategoriesAsNestedArray()
    {
        $categories['quotes'] = QuoteCategory::select('id', 'name')->get();
        $categories['terms'] = TermCategory::select('id', 'name')->get();
        $categories['videos'] = VideoCategory::select('id', 'name')->get();

        return $categories;
    }

    /**
     * Add supported type links to each category and its children.
     *
     * @param  \Illuminate\Support\Collection  $categories
     * @return void
     */
    private function addSupportedTypeLinksToCategories(Collection $categories, $nestedCategoriesArray): void
    {
        $categories->each(function ($category) use ($nestedCategoriesArray) {
            $category->supported_type_links = $this->getSupportedTypeLinksForCategory($category, $nestedCategoriesArray);

            if ($category->children) {
                $this->addSupportedTypeLinksToCategories($category->children, $nestedCategoriesArray);
            }
        });
    }

    /**
     * Get supported type links for a specific category.
     *
     * @param  \Illuminate\Database\Eloquent\Model  $category
     * @return array
     */
    private function getSupportedTypeLinksForCategory($category, $nestedCategoriesArray): array
    {
        $links = [];

        if ($nestedCategoriesArray['quotes']->contains('name', $category->name)) {
            $links[] = [
                'label' => 'Цитаты и Афоризмы',
                'href' => route('quotes.category', $category->slug)
            ];
        }

        if ($nestedCategoriesArray['terms']->contains('name', $category->name)) {
            $links[] = [
                'label' => 'Термины',
                'href' => route('terms.category', $category->slug)
            ];
        }

        if ($nestedCategoriesArray['videos']->contains('name', $category->name)) {
            $links[] = [
                'label' => 'Видео',
                'href' => route('videos.category', $category->slug)
            ];
        }

        // Avoid duplicate dictionary links
        if ($nestedCategoriesArray['terms']->contains('name', $category->name) && !array_key_exists('Словарь', $links)) {
            $links[] = [
                'label' => 'Словарь',
                'href' => route('vocabulary.category', $category->slug)
            ];
        }

        return $links;
    }
}
