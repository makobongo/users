<?php

namespace Ignite\Users\Sidebar;

use Maatwebsite\Sidebar\Group;
use Maatwebsite\Sidebar\Item;
use Maatwebsite\Sidebar\Menu;
use Maatwebsite\Sidebar\SidebarExtender as Panda;

class SidebarExtender implements Panda
{

    /**
     * @param Menu $menu
     *
     * @return Menu
     */
    public function extendWith(Menu $menu) {

        $menu->group('Dashboard', function (Group $group) {
            $group->item('Users & Employees', function(Item $item) {
                $item->name(m_setting('users.sidebar_name_users_and_employees'));
                $item->weight(100);
                $item->authorize(permit('users.*'));
                $item->icon('mdi mdi-account-group-outline');

                $item->item(m_setting('users.sidebar_name_new_user'), function (Item $item) {
                    $item->icon('mdi mdi-account-multiple-plus-outline');
                    $item->authorize(permit('users.store'));
                    $item->route('users.create');
                });

                $item->item(m_setting('users.sidebar_name_all_users'), function (Item $item) {
                    $item->icon('mdi mdi-format-list-bulleted-square');
                    $item->authorize(permit('users.index'));
                    $item->route('users.index');
                });

                if(m_setting('users.enable_injuries'))
                {
                    $item->item('Injuries', function (Item $item) {
                        $item->icon('mdi mdi-wheelchair-accessibility');
                        $item->authorize(permit('users.injuries.index'));
                        $item->route('users.injuries.index');
                    });
                }

                if(m_setting('users.enable_chits')) {
                    $item->item('Chits', function (Item $item) {
                        $item->icon('mdi mdi-file-delimited-outline');
                        $item->authorize(permit('users.chits.index'));
                        $item->route('users.chits.index');
                    });
                }

                $item->item(m_setting('users.sidebar_name_roles'), function (Item $item) {
                    $item->icon('mdi mdi-security-network');
                    //$item->authorize(permit('roles'));
                    $item->authorize(permit('users.roles.index'));
                    $item->route('users.role.index');
                });

                if(m_setting('users.enable_employee_categories')) {
                    $item->item(m_setting('users.sidebar_name_employee_categories'), function (Item $item) {
                        $item->icon('mdi mdi-folder-account-outline');
                        $item->authorize(permit('user.*'));
                        $item->route('users.employee-categories.index');
                    });
                }

                if(m_setting('users.enable_check_roll_number')) {
                    $item->item(m_setting('users.sidebar_name_checkroll_numbers'), function (Item $item) {
                        $item->icon('mdi mdi-music-accidental-sharp');
                        $item->authorize(permit('user.*'));
                        $item->route('users.checkroll.index');
                    });
                }

            });

            /*$group->item('My Profile', function(Item $item) {
                $item->weight(50);
                // $item->authorize(permit('user.*'));
                $item->icon('fa fa-user');

                if(m_setting('users.enable_dependants')) {
                    // $item->item('My Dependants', function (Item $item) {
                    //     $item->icon('fa fa-child');
                    //     $item->authorize(permit('dependants.*'));
                    //     $item->route('users.dependants.index', [doe()->id]);
                    // });
                }

                $item->item('Manage Password', function (Item $item) {
                    $item->icon('fa fa-lock');
                    $item->route('users.manage-password');
                });
            });*/

            if (m_setting('core.enable_worksheets_upload')) {
                $group->item('Upload Excel Sheets', function (Item $item) {
                    $item->item('Upload Employees', function (Item $item) {
                        $item->icon('fa fa-users');
                        $item->authorize(permit('user.*'));
                        $item->route('users.upload.employees');
                    });

                    $item->item('Upload Dependants', function (Item $item) {
                        $item->icon('mdi mdi-home-account');
                        $item->authorize(permit('user.*'));
                        $item->route('users.upload.dependants');
                    });

                });
            }

        });
        return $menu;
    }
}
