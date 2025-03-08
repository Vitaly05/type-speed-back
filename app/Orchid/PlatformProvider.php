<?php

declare( strict_types=1 );

namespace App\Orchid;

use Orchid\Platform\Dashboard;
use Orchid\Platform\ItemPermission;
use Orchid\Platform\OrchidServiceProvider;
use Orchid\Screen\Actions\Menu;

class PlatformProvider extends OrchidServiceProvider
{
	/**
	 * Bootstrap the application services.
	 *
	 * @param Dashboard $dashboard
	 *
	 * @return void
	 */
	public function boot( Dashboard $dashboard ) : void
	{
		parent::boot( $dashboard );

		// ...
	}

	/**
	 * Register the application menu.
	 *
	 * @return Menu[]
	 */
	public function menu() : array
	{
		return [
			Menu::make( __( 'Добро пожаловать' ) )
				->icon( 'bs.house' )
				->title( __( 'Главная' ) )
				->route( config( 'platform.index' ) ),

			Menu::make( __( 'Текста' ) )
				->icon( 'bs.book' )
				->title( __( 'Текста' ) )
				->permission( 'platform.texts' )
				->route( 'platform.texts' ),

			Menu::make( __( 'Users' ) )
				->icon( 'bs.people' )
				->route( 'platform.systems.users' )
				->permission( 'platform.systems.users' )
				->title( __( 'Управление доступом' ) ),

//			Menu::make( __( 'Roles' ) )
//				->icon( 'bs.shield' )
//				->route( 'platform.systems.roles' )
//				->permission( 'platform.systems.roles' )
//				->divider(),
		];
	}

	/**
	 * Register permissions for the application.
	 *
	 * @return ItemPermission[]
	 */
	public function permissions() : array
	{
		return [
			ItemPermission::group( __( 'System' ) )
				->addPermission( 'platform.systems.roles', __( 'Roles' ) )
				->addPermission( 'platform.systems.users', __( 'Users' ) ),
			ItemPermission::group( __( 'Base' ) )
				->addPermission( 'platform.texts', __( 'Texts' ) ),
		];
	}
}
