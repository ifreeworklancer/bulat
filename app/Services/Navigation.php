<?php

namespace App\Services;

use App\Models\Catalog\Order;
use App\Models\Questionary\Answer;
use App\Models\Questionary\Question;
use Illuminate\Support\Facades\Auth;
use Talanoff\ImpressionAdmin\Elements\NavigationElement;

class Navigation
{
	public function frontend()
	{
		$questionary = [];

		$items = [
			(object)[
				'name' => trans('navigation.header.catalog'),
				'route' => route('app.catalog.index'),
			],
			(object)[
				'name' => trans('navigation.header.about'),
				'route' => route('app.about'),
			],
			(object)[
				'name' => trans('navigation.header.contacts'),
				'route' => route('app.contacts'),
			],
			(object)[
				'name' => trans('navigation.header.terms'),
				'route' => route('app.terms')
			]
		];

		if (Auth::check() && Question::count()) {
			$questionary = [
				(object)[
					'name' => trans('navigation.header.questionary'),
					'route' => route('app.questionary.index')
				]
			];
		}

		return array_merge($items, $questionary);
	}

	public function backend()
	{
		return [
			new NavigationElement([
				'name' => 'Заказы',
				'route' => 'orders',
				'icon' => 'i-wallet',
				'submenu' => null,
				'unread' => Order::whereIn('status', ['processing', 'no_dial'])->count(),
			]),
			new NavigationElement([
				'name' => 'Анкета',
				'route' => 'question',
				'icon' => 'i-book',
				'compare' => ['questions', 'answers'],
				'unread' => Answer::where('status', ['processing'])->count(),
				'submenu' => [
					'questions' => [
						'name' => 'Вопросы',
						'route' => 'admin.questions.index',
					],
					'answers' => [
						'name' => 'Ответы',
						'route' => 'admin.answers.index',
					],
				],
			]),
			new NavigationElement([
				'name' => 'Каталог',
				'route' => 'products',
				'icon' => 'i-versions',
				'compare' => ['products', 'categories'],
				'submenu' => [
					'products' => [
						'name' => 'Товары',
						'route' => 'admin.products.index',
					],
					'categories' => [
						'name' => 'Категории',
						'route' => 'admin.categories.index',
					],
				],
			]),
			new NavigationElement([
				'name' => 'Статьи',
				'route' => 'articles',
				'icon' => 'i-newspaper',
				'compare' => ['articles', 'tags', 'groups'],
				'submenu' => [
					'articles' => [
						'name' => 'Все статьи',
						'route' => 'admin.articles.index',
					],
					'tags' => [
						'name' => 'Тэги',
						'route' => 'admin.tags.index',
					],
					'groups' => [
						'name' => 'Группы тэгов',
						'route' => 'admin.groups.index',
					],
				],
			]),
			new NavigationElement([
				'name' => 'Слайды',
				'route' => 'slides',
				'icon' => 'i-image',
				'submenu' => null,
			]),
			new NavigationElement([
				'name' => 'Пользователи',
				'route' => 'users',
				'icon' => 'i-users',
				'submenu' => null,
			]),

			//			new NavigationElement([
			//				'name' => 'Настройки',
			//				'route' => 'settings',
			//				'submenu' => null,
			//			]),
		];
	}
}
