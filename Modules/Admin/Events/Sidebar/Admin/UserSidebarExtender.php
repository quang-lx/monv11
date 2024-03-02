<?php

namespace Modules\Admin\Events\Sidebar\Admin;


use Maatwebsite\Sidebar\Group;
use Maatwebsite\Sidebar\Item;
use Maatwebsite\Sidebar\Menu;
use Modules\Admin\Sidebar\AbstractAdminSidebar;

class UserSidebarExtender extends AbstractAdminSidebar
{

    /**
     * Method used to define your sidebar menu groups and items
     * @param Menu $menu
     * @return Menu
     */
    public function extendWith(Menu $menu)
    {

        $menu->group('system administration', function (Group $group) {
            $group->hideHeading(true);
            $group->item(trans('backend::sidebar.home'), function (Item $item) {
                $item->icon('fas custom-icon home-icon');
                $item->weight(10);
                $item->authorize(
                    $this->auth->hasAccess('admin.dashboard.index')
                );
                $item->route('admin.dashboard.index');
                $item->isActiveWhen('/admin');

            });
            $group->item(trans('backend::sidebar.system administration'), function (Item $item) {
                $item->icon('fas custom-icon setting-icon');
                $item->weight(10);
                $item->authorize(
                    $this->auth->hasAccess('admin.admins.index')
                );
                //                $item->item(trans('backend::sidebar.permissions'), function (Item $item) {
//
//                    $item->weight(0);
//
//                    $item->route('admin.permissions.index');
//                    $item->authorize(
//                        $this->auth->hasAccess('admin.permissions.index')
//                    );
//                });
                $item->item(trans('backend::sidebar.roles'), function (Item $item) {

                    $item->weight(0);

                    $item->route('admin.roles.index');
                    $item->authorize(
                        $this->auth->hasAccess('admin.roles.index')
                    );
                });

                $item->item(trans('backend::sidebar.admins'), function (Item $item) {

                    $item->weight(0);

                    $item->route('admin.admins.index');
                    $item->authorize(
                        $this->auth->hasAccess('admin.admins.index')
                    );
                });

            });

            $group->item(trans('backend::sidebar.device'), function (Item $item) {
                $item->icon('fas custom-icon document');
                $item->weight(10);
                $item->authorize(
                    $this->auth->hasAccess('admin.device.index')
                );
                $item->route('admin.device.index');

            });

//            $group->item(trans('backend::sidebar.dashboard'), function (Item $item) {
//                $item->icon('fas custom-icon user-square');
//                $item->weight(10);
//                $item->authorize(
//                    $this->auth->hasAccess('admin.dashboard.index')
//                );
//                $item->route('admin.dashboard.index');
//                $item->isActiveWhen('/admin');
//
//            });

        });


        return $menu;

    }
}
