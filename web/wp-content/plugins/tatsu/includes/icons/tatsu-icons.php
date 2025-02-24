<?php
add_action( 'tatsu_register_icons', 'tatsu_register_tatsu_icons' );
function tatsu_register_tatsu_icons() {
    $tatsu_icons = array(
		"tatsu-icon-music",
		"tatsu-icon-wallet",
		"tatsu-icon-search",
		"tatsu-icon-mail",
		"tatsu-icon-heart",
		"tatsu-icon-star",
		"tatsu-icon-key",
		"tatsu-icon-doc",
		"tatsu-icon-user",
		"tatsu-icon-videocam",
		"tatsu-icon-camera",
		"tatsu-icon-photo",
		"tatsu-icon-attach",
		"tatsu-icon-lock",
		"tatsu-icon-eye",
		"tatsu-icon-tag",
		"tatsu-icon-thumbs-up",
		"tatsu-icon-pencil",
		"tatsu-icon-comment",
		"tatsu-icon-location",
		"tatsu-icon-cup",
		"tatsu-icon-trash",
		"tatsu-icon-database",
		"tatsu-icon-megaphone",
		"tatsu-icon-graduation-cap",
		"tatsu-icon-fire",
		"tatsu-icon-paper-plane",
		"tatsu-icon-cloud",
		"tatsu-icon-globe",
		"tatsu-icon-inbox",
		"tatsu-icon-cd",
		"tatsu-icon-mobile",
		"tatsu-icon-desktop",
		"tatsu-icon-tv",
		"tatsu-icon-lightbulb",
		"tatsu-icon-clock",
		"tatsu-icon-sound",
		"tatsu-icon-calendar",
		"tatsu-icon-params",
		"tatsu-icon-cog",
		"tatsu-icon-note",
		"tatsu-icon-beaker",
		"tatsu-icon-truck",
		"tatsu-icon-money",
		"tatsu-icon-food",
		"tatsu-icon-shop",
		"tatsu-icon-diamond",
		"tatsu-icon-t-shirt",
		"tatsu-icon-twitter",
		"tatsu-icon-facebook",
		"tatsu-icon-github-circled",
		"tatsu-icon-gplus",
		"tatsu-icon-linkedin",
		"tatsu-icon-tiktok",
		"tatsu-icon-html5",
		"tatsu-icon-css3",
		"tatsu-icon-euro",
		"tatsu-icon-pound",
		"tatsu-icon-dollar",
		"tatsu-icon-rupee",
		"tatsu-icon-yen",
		"tatsu-icon-rouble",
		"tatsu-icon-bitcoin",
		"tatsu-icon-youtube",
		"tatsu-icon-xing",
		"tatsu-icon-youtube-play",
		"tatsu-icon-dropbox",
		"tatsu-icon-instagram",
		"tatsu-icon-flickr",
		"tatsu-icon-bitbucket",
		"tatsu-icon-tumblr",
		"tatsu-icon-apple",
		"tatsu-icon-windows",
		"tatsu-icon-android",
		"tatsu-icon-dribbble",
		"tatsu-icon-skype",
		"tatsu-icon-trello",
		"tatsu-icon-vkontakte",
		"tatsu-icon-weibo",
		"tatsu-icon-slack",
		"tatsu-icon-wordpress",
		"tatsu-icon-google",
		"tatsu-icon-reddit",
		"tatsu-icon-delicious",
		"tatsu-icon-digg",
		"tatsu-icon-drupal",
		"tatsu-icon-behance",
		"tatsu-icon-steam-squared",
		"tatsu-icon-spotify",
		"tatsu-icon-deviantart",
		"tatsu-icon-soundcloud",
		"tatsu-icon-vine",
		"tatsu-icon-git",
		"tatsu-icon-wechat",
		"tatsu-icon-yelp",
		"tatsu-icon-paypal",
		"tatsu-icon-cc-visa",
		"tatsu-icon-cc-paypal",
		"tatsu-icon-cc-stripe",
		"tatsu-icon-lastfm",
		"tatsu-icon-dashcube",
		"tatsu-icon-sellsy",
		"tatsu-icon-pinterest",
		"tatsu-icon-whatsapp",
		"tatsu-icon-medium",
		"tatsu-icon-tripadvisor",
		"tatsu-icon-safari",
		"tatsu-icon-chrome",
		"tatsu-icon-firefox",
		"tatsu-icon-opera",
		"tatsu-icon-internet-explorer",
		"tatsu-icon-amazon",
		"tatsu-icon-houzz",
		"tatsu-icon-vimeo",
		"tatsu-icon-edge",
		"tatsu-icon-credit-card-alt",
		"tatsu-icon-usb",
		"tatsu-icon-bluetooth",
		"tatsu-icon-activity",
		"tatsu-icon-airplay",
		"tatsu-icon-alert-circle",
		"tatsu-icon-alert-octagon",
		"tatsu-icon-alert-triangle",
		"tatsu-icon-align-center",
		"tatsu-icon-align-justify",
		"tatsu-icon-align-left2",
		"tatsu-icon-align-right2",
		"tatsu-icon-anchor",
		"tatsu-icon-aperture",
		"tatsu-icon-archive2",
		"tatsu-icon-arrow-down2",
		"tatsu-icon-arrow-down-circle",
		"tatsu-icon-arrow-down-left",
		"tatsu-icon-arrow-down-right",
		"tatsu-icon-arrow-left2",
		"tatsu-icon-arrow-left-circle",
		"tatsu-icon-arrow-right2",
		"tatsu-icon-arrow-right-circle",
		"tatsu-icon-arrow-up2",
		"tatsu-icon-arrow-up-circle",
		"tatsu-icon-arrow-up-left",
		"tatsu-icon-arrow-up-right",
		"tatsu-icon-at-sign",
		"tatsu-icon-award",
		"tatsu-icon-bar-chart",
		"tatsu-icon-bar-chart-2",
		"tatsu-icon-battery2",
		"tatsu-icon-battery-charging",
		"tatsu-icon-bell2",
		"tatsu-icon-bell-off",
		"tatsu-icon-bluetooth1",
		"tatsu-icon-book2",
		"tatsu-icon-book-open",
		"tatsu-icon-bookmark2",
		"tatsu-icon-box2",
		"tatsu-icon-briefcase2",
		"tatsu-icon-calendar2",
		"tatsu-icon-camera2",
		"tatsu-icon-camera-off",
		"tatsu-icon-cast",
		"tatsu-icon-check2",
		"tatsu-icon-check-circle",
		"tatsu-icon-check-square",
		"tatsu-icon-chevron-down2",
		"tatsu-icon-chevron-left2",
		"tatsu-icon-chevron-right2",
		"tatsu-icon-chevron-up2",
		"tatsu-icon-chevrons-down",
		"tatsu-icon-chevrons-left",
		"tatsu-icon-chevrons-right",
		"tatsu-icon-chevrons-up",
		"tatsu-icon-chrome1",
		"tatsu-icon-circle",
		"tatsu-icon-clipboard2",
		"tatsu-icon-clock2",
		"tatsu-icon-cloud2",
		"tatsu-icon-cloud-drizzle",
		"tatsu-icon-cloud-lightning",
		"tatsu-icon-cloud-off",
		"tatsu-icon-cloud-rain",
		"tatsu-icon-cloud-snow",
		"tatsu-icon-code2",
		"tatsu-icon-codepen",
		"tatsu-icon-command",
		"tatsu-icon-compass2",
		"tatsu-icon-copy2",
		"tatsu-icon-corner-down-left",
		"tatsu-icon-corner-down-right",
		"tatsu-icon-corner-left-down",
		"tatsu-icon-corner-left-up",
		"tatsu-icon-corner-right-down",
		"tatsu-icon-corner-right-up",
		"tatsu-icon-corner-up-left",
		"tatsu-icon-corner-up-right",
		"tatsu-icon-cpu",
		"tatsu-icon-credit-card2",
		"tatsu-icon-crop2",
		"tatsu-icon-crosshair",
		"tatsu-icon-database2",
		"tatsu-icon-delete",
		"tatsu-icon-disc",
		"tatsu-icon-dollar-sign",
		"tatsu-icon-download2",
		"tatsu-icon-download-cloud",
		"tatsu-icon-droplet",
		"tatsu-icon-edit2",
		"tatsu-icon-edit-2",
		"tatsu-icon-edit-3",
		"tatsu-icon-external-link",
		"tatsu-icon-eye2",
		"tatsu-icon-eye-off",
		"tatsu-icon-fast-forward",
		"tatsu-icon-feather2",
		"tatsu-icon-file",
		"tatsu-icon-file-minus",
		"tatsu-icon-file-plus",
		"tatsu-icon-file-text",
		"tatsu-icon-film",
		"tatsu-icon-filter",
		"tatsu-icon-flag2",
		"tatsu-icon-folder2",
		"tatsu-icon-folder-minus",
		"tatsu-icon-folder-plus",
		"tatsu-icon-gift",
		"tatsu-icon-github2",
		"tatsu-icon-gitlab",
		"tatsu-icon-globe2",
		"tatsu-icon-grid2",
		"tatsu-icon-hard-drive",
		"tatsu-icon-hash",
		"tatsu-icon-headphones",
		"tatsu-icon-heart2",
		"tatsu-icon-help-circle",
		"tatsu-icon-home2",
		"tatsu-icon-image2",
		"tatsu-icon-inbox2",
		"tatsu-icon-info2",
		"tatsu-icon-instagram2",
		"tatsu-icon-italic",
		"tatsu-icon-layers2",
		"tatsu-icon-layout",
		"tatsu-icon-life-buoy",
		"tatsu-icon-link2",
		"tatsu-icon-link-2",
		"tatsu-icon-linkedin2",
		"tatsu-icon-list2",
		"tatsu-icon-loader",
		"tatsu-icon-lock2",
		"tatsu-icon-log-in",
		"tatsu-icon-log-out2",
		"tatsu-icon-mail2",
		"tatsu-icon-map2",
		"tatsu-icon-map-pin",
		"tatsu-icon-maximize",
		"tatsu-icon-maximize-2",
		"tatsu-icon-menu2",
		"tatsu-icon-message-circle",
		"tatsu-icon-message-square",
		"tatsu-icon-mic2",
		"tatsu-icon-mic-off",
		"tatsu-icon-minimize",
		"tatsu-icon-minimize-2",
		"tatsu-icon-minus2",
		"tatsu-icon-minus-circle",
		"tatsu-icon-minus-square",
		"tatsu-icon-monitor",
		"tatsu-icon-moon2",
		"tatsu-icon-more-horizontal",
		"tatsu-icon-more-vertical",
		"tatsu-icon-move",
		"tatsu-icon-music2",
		"tatsu-icon-navigation",
		"tatsu-icon-navigation-2",
		"tatsu-icon-octagon",
		"tatsu-icon-package",
		"tatsu-icon-paperclip",
		"tatsu-icon-pause",
		"tatsu-icon-pause-circle",
		"tatsu-icon-percent",
		"tatsu-icon-phone2",
		"tatsu-icon-phone-call",
		"tatsu-icon-phone-forwarded",
		"tatsu-icon-phone-incoming",
		"tatsu-icon-phone-missed",
		"tatsu-icon-phone-off",
		"tatsu-icon-phone-outgoing",
		"tatsu-icon-pie-chart2",
		"tatsu-icon-play",
		"tatsu-icon-play-circle",
		"tatsu-icon-plus2",
		"tatsu-icon-plus-circle",
		"tatsu-icon-plus-square",
		"tatsu-icon-pocket",
		"tatsu-icon-power",
		"tatsu-icon-printer",
		"tatsu-icon-radio2",
		"tatsu-icon-refresh-ccw",
		"tatsu-icon-refresh-cw",
		"tatsu-icon-repeat",
		"tatsu-icon-rewind",
		"tatsu-icon-rotate-ccw",
		"tatsu-icon-rotate-cw",
		"tatsu-icon-rss2",
		"tatsu-icon-save2",
		"tatsu-icon-scissors2",
		"tatsu-icon-search1",
		"tatsu-icon-send",
		"tatsu-icon-server",
		"tatsu-icon-settings",
		"tatsu-icon-share",
		"tatsu-icon-share-2",
		"tatsu-icon-shield2",
		"tatsu-icon-shield-off",
		"tatsu-icon-shopping-bag2",
		"tatsu-icon-shopping-cart2",
		"tatsu-icon-shuffle2",
		"tatsu-icon-sidebar",
		"tatsu-icon-skip-back",
		"tatsu-icon-skip-forward",
		"tatsu-icon-slack1",
		"tatsu-icon-slash",
		"tatsu-icon-sliders",
		"tatsu-icon-smartphone",
		"tatsu-icon-speaker",
		"tatsu-icon-square",
		"tatsu-icon-star2",
		"tatsu-icon-stop-circle",
		"tatsu-icon-sun",
		"tatsu-icon-sunrise",
		"tatsu-icon-sunset",
		"tatsu-icon-tablet2",
		"tatsu-icon-tag2",
		"tatsu-icon-target",
		"tatsu-icon-terminal",
		"tatsu-icon-thermometer2",
		"tatsu-icon-thumbs-down2",
		"tatsu-icon-thumbs-up2",
		"tatsu-icon-toggle-left",
		"tatsu-icon-toggle-right",
		"tatsu-icon-trash2",
		"tatsu-icon-trash-2",
		"tatsu-icon-trending-down",
		"tatsu-icon-trending-up",
		"tatsu-icon-triangle",
		"tatsu-icon-truck1",
		"tatsu-icon-tv2",
		"tatsu-icon-twitter2",
		"tatsu-icon-type",
		"tatsu-icon-umbrella",
		"tatsu-icon-underline",
		"tatsu-icon-unlock",
		"tatsu-icon-upload2",
		"tatsu-icon-upload-cloud",
		"tatsu-icon-user2",
		"tatsu-icon-user-check",
		"tatsu-icon-user-minus",
		"tatsu-icon-user-plus",
		"tatsu-icon-user-x",
		"tatsu-icon-users2",
		"tatsu-icon-video2",
		"tatsu-icon-video-off",
		"tatsu-icon-voicemail2",
		"tatsu-icon-volume",
		"tatsu-icon-volume-1",
		"tatsu-icon-volume-2",
		"tatsu-icon-volume-x",
		"tatsu-icon-watch",
		"tatsu-icon-wifi",
		"tatsu-icon-wifi-off",
		"tatsu-icon-wind",
		"tatsu-icon-x",
		"tatsu-icon-x-circle",
		"tatsu-icon-x-square",
		"tatsu-icon-youtube2",
		"tatsu-icon-zap",
		"tatsu-icon-zap-off",
		"tatsu-icon-zoom-in",
		"tatsu-icon-zoom-out",
		"tatsu-icon-youtube1",
		"tatsu-icon-skype1",
		"tatsu-icon-picasa",
		"tatsu-icon-google-play",
		"tatsu-icon-google-hangouts",
		"tatsu-icon-google-drive",
		"tatsu-icon-flickr1",
		"tatsu-icon-evernote",
		"tatsu-icon-basecamp",
		"tatsu-icon-baidu",
		"tatsu-icon-px",
		"tatsu-icon-location-pin",
		"tatsu-icon-inbox1",
		"tatsu-icon-water",
		"tatsu-icon-warning",
		"tatsu-icon-wallet1",
		"tatsu-icon-voicemail",
		"tatsu-icon-vinyl",
		"tatsu-icon-video",
		"tatsu-icon-video-camera",
		"tatsu-icon-v-card",
		"tatsu-icon-users",
		"tatsu-icon-user1",
		"tatsu-icon-upload",
		"tatsu-icon-upload-to-cloud",
		"tatsu-icon-untag",
		"tatsu-icon-unread",
		"tatsu-icon-uninstall",
		"tatsu-icon-typing",
		"tatsu-icon-tv1",
		"tatsu-icon-trophy",
		"tatsu-icon-triangle-up",
		"tatsu-icon-triangle-right",
		"tatsu-icon-triangle-left",
		"tatsu-icon-triangle-down",
		"tatsu-icon-tree",
		"tatsu-icon-trash1",
		"tatsu-icon-traffic-cone",
		"tatsu-icon-tools",
		"tatsu-icon-time-slot",
		"tatsu-icon-ticket",
		"tatsu-icon-thunder-cloud",
		"tatsu-icon-thumbs-up1",
		"tatsu-icon-thumbs-down",
		"tatsu-icon-thermometer",
		"tatsu-icon-text",
		"tatsu-icon-text-document",
		"tatsu-icon-text-document-inverted",
		"tatsu-icon-tag1",
		"tatsu-icon-tablet",
		"tatsu-icon-tablet-mobile-combo",
		"tatsu-icon-switch",
		"tatsu-icon-sweden",
		"tatsu-icon-swap",
		"tatsu-icon-suitcase",
		"tatsu-icon-stopwatch",
		"tatsu-icon-star1",
		"tatsu-icon-star-outlined",
		"tatsu-icon-squared-plus",
		"tatsu-icon-squared-minus",
		"tatsu-icon-squared-cross",
		"tatsu-icon-spreadsheet",
		"tatsu-icon-sports-club",
		"tatsu-icon-sound1",
		"tatsu-icon-sound-mute",
		"tatsu-icon-sound-mix",
		"tatsu-icon-signal",
		"tatsu-icon-shuffle",
		"tatsu-icon-shopping-cart",
		"tatsu-icon-shopping-basket",
		"tatsu-icon-shopping-bag",
		"tatsu-icon-shop1",
		"tatsu-icon-shield",
		"tatsu-icon-shareable",
		"tatsu-icon-share-alternative",
		"tatsu-icon-select-arrows",
		"tatsu-icon-scissors",
		"tatsu-icon-save",
		"tatsu-icon-ruler",
		"tatsu-icon-rss",
		"tatsu-icon-round-brush",
		"tatsu-icon-rocket",
		"tatsu-icon-retweet",
		"tatsu-icon-resize-full-screen",
		"tatsu-icon-resize-100",
		"tatsu-icon-reply",
		"tatsu-icon-reply-all",
		"tatsu-icon-remove-user",
		"tatsu-icon-radio",
		"tatsu-icon-quote",
		"tatsu-icon-publish",
		"tatsu-icon-progress-two",
		"tatsu-icon-progress-one",
		"tatsu-icon-progress-full",
		"tatsu-icon-progress-empty",
		"tatsu-icon-print",
		"tatsu-icon-price-tag",
		"tatsu-icon-price-ribbon",
		"tatsu-icon-power-plug",
		"tatsu-icon-popup",
		"tatsu-icon-plus",
		"tatsu-icon-pin",
		"tatsu-icon-pie-chart",
		"tatsu-icon-phone",
		"tatsu-icon-pencil1",
		"tatsu-icon-paper-plane1",
		"tatsu-icon-palette",
		"tatsu-icon-open-book",
		"tatsu-icon-old-phone",
		"tatsu-icon-old-mobile",
		"tatsu-icon-notifications-off",
		"tatsu-icon-notification",
		"tatsu-icon-note1",
		"tatsu-icon-newsletter",
		"tatsu-icon-news",
		"tatsu-icon-new",
		"tatsu-icon-new-message",
		"tatsu-icon-network",
		"tatsu-icon-music1",
		"tatsu-icon-mouse",
		"tatsu-icon-mouse-pointer",
		"tatsu-icon-moon",
		"tatsu-icon-modern-mic",
		"tatsu-icon-mobile1",
		"tatsu-icon-minus",
		"tatsu-icon-mic",
		"tatsu-icon-message",
		"tatsu-icon-merge",
		"tatsu-icon-menu",
		"tatsu-icon-megaphone1",
		"tatsu-icon-medal",
		"tatsu-icon-mask",
		"tatsu-icon-map",
		"tatsu-icon-man",
		"tatsu-icon-mail1",
		"tatsu-icon-magnifying-glass",
		"tatsu-icon-magnet",
		"tatsu-icon-loop",
		"tatsu-icon-login",
		"tatsu-icon-log-out",
		"tatsu-icon-lock1",
		"tatsu-icon-lock-open",
		"tatsu-icon-location1",
		"tatsu-icon-list",
		"tatsu-icon-link",
		"tatsu-icon-light-up",
		"tatsu-icon-light-down",
		"tatsu-icon-light-bulb",
		"tatsu-icon-lifebuoy",
		"tatsu-icon-level-up",
		"tatsu-icon-level-down",
		"tatsu-icon-leaf",
		"tatsu-icon-layers",
		"tatsu-icon-laptop",
		"tatsu-icon-language",
		"tatsu-icon-landline",
		"tatsu-icon-lab-flask",
		"tatsu-icon-keyboard",
		"tatsu-icon-key1",
		"tatsu-icon-install",
		"tatsu-icon-info",
		"tatsu-icon-info-with-circle",
		"tatsu-icon-infinity",
		"tatsu-icon-images",
		"tatsu-icon-image",
		"tatsu-icon-image-inverted",
		"tatsu-icon-hour-glass",
		"tatsu-icon-home",
		"tatsu-icon-help",
		"tatsu-icon-help-with-circle",
		"tatsu-icon-heart1",
		"tatsu-icon-heart-outlined",
		"tatsu-icon-hand",
		"tatsu-icon-hair-cross",
		"tatsu-icon-grid",
		"tatsu-icon-graduation-cap1",
		"tatsu-icon-globe1",
		"tatsu-icon-gauge",
		"tatsu-icon-game-controller",
		"tatsu-icon-funnel",
		"tatsu-icon-forward",
		"tatsu-icon-folder",
		"tatsu-icon-folder-video",
		"tatsu-icon-folder-music",
		"tatsu-icon-folder-images",
		"tatsu-icon-flower",
		"tatsu-icon-flow-tree",
		"tatsu-icon-flow-parallel",
		"tatsu-icon-flow-line",
		"tatsu-icon-flow-cascade",
		"tatsu-icon-flow-branch",
		"tatsu-icon-flat-brush",
		"tatsu-icon-flashlight",
		"tatsu-icon-flash",
		"tatsu-icon-flag",
		"tatsu-icon-fingerprint",
		"tatsu-icon-feather",
		"tatsu-icon-eye1",
		"tatsu-icon-eye-with-line",
		"tatsu-icon-export",
		"tatsu-icon-eraser",
		"tatsu-icon-erase",
		"tatsu-icon-emoji-sad",
		"tatsu-icon-emoji-neutral",
		"tatsu-icon-emoji-happy",
		"tatsu-icon-emoji-flirt",
		"tatsu-icon-email",
		"tatsu-icon-edit",
		"tatsu-icon-drop",
		"tatsu-icon-drive",
		"tatsu-icon-drink",
		"tatsu-icon-download",
		"tatsu-icon-dots-three-vertical",
		"tatsu-icon-dots-three-horizontal",
		"tatsu-icon-documents",
		"tatsu-icon-document",
		"tatsu-icon-document-landscape",
		"tatsu-icon-direction",
		"tatsu-icon-database1",
		"tatsu-icon-cycle",
		"tatsu-icon-cw",
		"tatsu-icon-cup1",
		"tatsu-icon-cross",
		"tatsu-icon-crop",
		"tatsu-icon-credit",
		"tatsu-icon-credit-card",
		"tatsu-icon-creative-commons",
		"tatsu-icon-creative-commons-sharealike",
		"tatsu-icon-creative-commons-share",
		"tatsu-icon-creative-commons-remix",
		"tatsu-icon-creative-commons-public-domain",
		"tatsu-icon-creative-commons-noncommercial-us",
		"tatsu-icon-creative-commons-noncommercial-eu",
		"tatsu-icon-creative-commons-noderivs",
		"tatsu-icon-creative-commons-attribution",
		"tatsu-icon-copy",
		"tatsu-icon-controller-stop",
		"tatsu-icon-controller-record",
		"tatsu-icon-controller-play",
		"tatsu-icon-controller-paus",
		"tatsu-icon-controller-next",
		"tatsu-icon-controller-jump-to-start",
		"tatsu-icon-controller-fast-forward",
		"tatsu-icon-controller-fast-backward",
		"tatsu-icon-compass",
		"tatsu-icon-colours",
		"tatsu-icon-cog1",
		"tatsu-icon-code",
		"tatsu-icon-cloud1",
		"tatsu-icon-clock1",
		"tatsu-icon-clipboard",
		"tatsu-icon-classic-computer",
		"tatsu-icon-clapperboard",
		"tatsu-icon-circular-graph",
		"tatsu-icon-circle-with-plus",
		"tatsu-icon-circle-with-minus",
		"tatsu-icon-circle-with-cross",
		"tatsu-icon-chevron-with-circle-up",
		"tatsu-icon-chevron-with-circle-right",
		"tatsu-icon-chevron-with-circle-left",
		"tatsu-icon-chevron-with-circle-down",
		"tatsu-icon-chevron-up",
		"tatsu-icon-chevron-thin-up",
		"tatsu-icon-chevron-thin-right",
		"tatsu-icon-chevron-thin-left",
		"tatsu-icon-chevron-thin-down",
		"tatsu-icon-chevron-small-up",
		"tatsu-icon-chevron-small-right",
		"tatsu-icon-chevron-small-left",
		"tatsu-icon-chevron-small-down",
		"tatsu-icon-chevron-right",
		"tatsu-icon-chevron-left",
		"tatsu-icon-chevron-down",
		"tatsu-icon-check",
		"tatsu-icon-chat",
		"tatsu-icon-ccw",
		"tatsu-icon-camera1",
		"tatsu-icon-calendar1",
		"tatsu-icon-calculator",
		"tatsu-icon-cake",
		"tatsu-icon-bug",
		"tatsu-icon-bucket",
		"tatsu-icon-brush",
		"tatsu-icon-browser",
		"tatsu-icon-briefcase",
		"tatsu-icon-box",
		"tatsu-icon-bowl",
		"tatsu-icon-bookmarks",
		"tatsu-icon-bookmark",
		"tatsu-icon-book",
		"tatsu-icon-block",
		"tatsu-icon-blackboard",
		"tatsu-icon-bell",
		"tatsu-icon-beamed-note",
		"tatsu-icon-battery",
		"tatsu-icon-bar-graph",
		"tatsu-icon-back",
		"tatsu-icon-back-in-time",
		"tatsu-icon-awareness-ribbon",
		"tatsu-icon-attachment",
		"tatsu-icon-arrow-with-circle-up",
		"tatsu-icon-arrow-with-circle-right",
		"tatsu-icon-arrow-with-circle-left",
		"tatsu-icon-arrow-with-circle-down",
		"tatsu-icon-arrow-up",
		"tatsu-icon-arrow-right",
		"tatsu-icon-arrow-long-up",
		"tatsu-icon-arrow-long-right",
		"tatsu-icon-arrow-long-left",
		"tatsu-icon-arrow-long-down",
		"tatsu-icon-arrow-left",
		"tatsu-icon-arrow-down",
		"tatsu-icon-arrow-bold-up",
		"tatsu-icon-arrow-bold-right",
		"tatsu-icon-arrow-bold-left",
		"tatsu-icon-arrow-bold-down",
		"tatsu-icon-area-graph",
		"tatsu-icon-archive",
		"tatsu-icon-align-vertical-middle",
		"tatsu-icon-align-top",
		"tatsu-icon-align-right",
		"tatsu-icon-align-left",
		"tatsu-icon-align-horizontal-middle",
		"tatsu-icon-align-bottom",
		"tatsu-icon-aircraft",
		"tatsu-icon-aircraft-take-off",
		"tatsu-icon-air",
		"tatsu-icon-adjust",
		"tatsu-icon-add-user",
		"tatsu-icon-add-to-list",
	);
	tatsu_register_icon_kit( 'tatsu_icons', esc_html__( 'Tatsu Icons', 'tatsu' ), $tatsu_icons, TATSU_PLUGIN_URL.'/includes/icons/tatsu_icons/tatsu-icons.css', TATSU_VERSION );
}  ?>