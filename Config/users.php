<?php

return [
    'titles' => [
        0 => 'Mr.',
        1 => 'Mrs.',
        2 => 'Ms.',
        3 => 'Dr.',
        4 => 'Prof.',
        5 => 'Eng.',
        6 => 'Capt.',
        7 => 'COL. RTD',
        8 => 'Cllr',
        9 => 'Justice',
        10 => 'REV',
    ],
    'status' => [
        0 => 'Inactive',
        1 => 'Active',
        2 => 'Suspended'
    ],
    'roles' => [
        'User',
        'sudo',
        'Receptionist',
        'Cashier',
        'Doctor',
        'Drug Stores Manger',
        'Lab Technician',
        'Nurse',
        'Pharmacist',
        'Physio Therapy Technician',
        'Radiology Technician',
        'Admin',
        'UltraSound Technician',
        'External User',
    ],
    'permissions' => [
        1 => ['name' => 'Reception', 'desc' => 'Add new patient, upload patient documents, create appointments,checkin patients'],
        2 => ['name' => 'Patient Evaluation', 'desc' => 'Record patient vitals, add treatment entry, add notes'],
        3 => ['name' => 'SMS', 'desc' => 'Send SMS messages, access contacts, read incoming messages'],
        4 => ['name' => 'Billing', 'desc' => 'Bill patients, receive payments and view patient accounts'],
        5 => ['name' => 'Reports', 'desc' => 'View system reports - includes cashier reports, doctor notes, and procedures'],
        6 => ['name' => 'Settings', 'desc' => 'Change system settings change values that affect system operations. *Only if you trust user'],
        7 => ['name' => 'Setup', 'desc' => 'Change initial system configurations.'],
    ],
    'admin_contact' => [
        'email' => 'admin@ech.co.ke',
        'phone' => '0722111222'
    ]
];
