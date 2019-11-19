<?php
return [
    //上传文件字段名
    "name" => "file",
    //上传路径，相对public 和 storage/app 目录
    "path" => "uploads",

    //允许大小 kb
    "size" => 1024 * 50,
    //允许的后缀，* 表示允许任意类型
    "extensions" => [
        "image" => [
            "jpg",
            "jpeg",
            "png",
            "bmp",
            "gif"
        ],
        "video" => [
            "mp4",
            "flv",
            "mkv",
            "avi"
        ],
        "attach" => [
            "zip",
            "rar",
            "doc",
            "txt",
            "pdf",
            "docx",
            "xls",
            "xlsx",
            "xlt",
        ],
        //所有类型
        "file"=>[
            "*"
        ]
    ],
    //上传到public目录文件类型
    "public" => [
        "attach",
        "image"
    ],
    //存储到storage目录的文件类型，可以用来存储原始文件，私有文件
    "storage" => [],
];
