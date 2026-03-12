<?php
namespace App\Models\Home;

class Home
{
    public function getData()
    {
        return [
            'title' => 'SUNN PORTAL',
            'welcome' => 'Welcome to SUNN Portal',

            // University info
            'university' => [
                'name' => 'State University of Northern Negros',
                'subtitle' => 'Unified Login Portal',
                'logo_icon' => 'bi-mortarboard-fill'
            ],

            // Footer info
            'footer' => [
                'phone' => '090909090909',
                'email' => 'sunn.edu.ph'
            ],

            // Portals info
            'portals' => [
                [
                    'title' => 'Employee Portal',
                    'description' => 'Access for faculty, staff, and general employees.',
                    'link' => 'employee/login',
                    'icon' => 'bi-person-badge',
                    'badge' => 'Most Used',
                    'class' => 'employee-portal',
                    'note' => 'Faculty • Staff • Employees',
                    'note_icon' => 'bi-people'
                ],
                [
                    'title' => 'PDC Portal',
                    'description' => 'Program Development Committee',
                    'link' => 'pdc/login',
                    'icon' => 'bi-diagram-3',
                    'badge' => '',
                    'class' => 'pdc-portal',
                    'note' => 'Academic Administration',
                    'note_icon' => 'bi-gear'
                ],
                [
                    'title' => 'Admin/HR Portal',
                    'description' => 'Administrative access for system administrators, HR personnel, and other authorized staff.',
                    'link' => 'admin/login',
                    'icon' => 'bi-shield-fill-check',
                    'badge' => 'Secure',
                    'class' => 'admin-portal',
                    'note' => 'Restricted Access',
                    'note_icon' => 'bi-shield-lock'
                ]
            ]
        ];
    }
}
