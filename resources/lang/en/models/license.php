<?php
return [
    'singular' => 'License',
    'plural' => 'Licenses',
    'group' => 'Licenses Generating',
    'fields' => [
        'id' => 'ID',
        'order_id' => 'Order No',
        'raft_company' => 'Raft Company',
        'box_raft_company_box_id' => 'Box No.',
        'camp_raft_company_box_id' => 'Camp No.',
        'date' => 'Date',
        'expiry_date' => 'Expiry Date',
        'tents_count' => 'Tents Count',
        'person_count' => 'Person Count',
        'camp_space' => 'Camp Space',
        'map_path' => 'Location Map',
        'final_attachment_path' => 'Final Report',
        'final_report_path' => 'Final Report',
        'final_report_note' => 'Reason',
    ],
    "raft_company_name" => ":name",
    "no_parent_name" => "المجلس التنسيقي لحجاج الداخل",
    "download_for_service_provider" => "عرض رخصة الإضافات",
    "types" => [
        1 => "Add-on license",
        2 => "Execution license",
    ],
];
