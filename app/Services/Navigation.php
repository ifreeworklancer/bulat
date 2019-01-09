<?php

namespace App\Services;

use App\Models\Catalog\Order;
use Talanoff\ImpressionAdmin\Elements\NavigationElement;

class Navigation
{
	public function frontend()
	{
		return [
			(object) [
				'name' => trans('navigation.header.home'),
				'route' => route('app.home'),
			],
			(object)[
				'name' => trans('navigation.header.catalog'),
				'route' => route('app.catalog.index'),
			],
			(object)[
				'name' => trans('navigation.header.articles'),
				'route' => route('app.articles.index'),
			],
			(object)[
				'name' => trans('navigation.header.about'),
				'route' => route('app.about'),
			],
			(object)[
				'name' => trans('navigation.header.contacts'),
				'route' => route('app.contacts'),
			],
		];
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
