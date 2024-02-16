<?php

return function ($kirby, $pages, $page) {
    // Fetch the 'feed' page
    $feedPage = $kirby->site()->page('feed');

    // Fetch the sections from the 'feed' page
    $sections = $feedPage->sections()->toPages();

    // Initialize an empty collection for the pages
    $pages = new Kirby\Cms\Pages();

    // Loop through the sections and add their children to the pages collection
    foreach ($sections as $section) {
        $pages = $pages->add($section->children()->listed());
    }

    // Sort the pages by date in descending order
    $pages = $pages->sortBy('date', 'desc');

    // Initialize an empty array for the feed items
    $items = array();

    // Fetch the 'rssblip' field from the 'feed' page
    $rssblip = (string)$feedPage->rssblip()->kirbytext();

    // Loop through each page
    foreach ($pages as $p) {
        // Get the cover image if the cover method exists, otherwise get the first image
        $cover = method_exists($p, 'cover') ? $p->cover() : $p->images()->first();

        // If there's an image, resize it to a max width and height of 500px and get its URL
        $coverUrl = $cover ? $cover->resize(500, 500)->url() : null;

        // Get the alt text and caption for the cover image
        $altText = $cover ? $cover->alt()->or('Cover image') : '';
        $caption = $cover ? (string)$cover->caption()->kirbytext() : '';

        // Get the content HTML and remove newline characters
        $content_html = str_replace("\n", "", (string)$p->text()->kirbytext());

        // Add a figure tag for the cover image at the beginning of the content HTML
        if ($coverUrl !== null) {
            $figure = '<figure><img src="' . $coverUrl . '" alt="' . $altText . '"><figcaption>' . $caption . '</figcaption></figure>';
            $content_html = $figure . $content_html;
        }

        // Fetch the 'materials' field from the page
        $materials = '';
        if ($p->materials()->isNotEmpty()) {
            $materials = '<h3>Materials:</h3> ' . (string)$p->materials(',')->kirbytext();
        }
        // Append the 'materials' field to the content HTML
        $content_html .= $materials;

        // Append the 'rssblip' field to the content HTML
        $content_html .= $rssblip;

        // Prepend the title of the parent section to the title of the page
        $title = $p->parent()->title() . ': ' . $p->title();

        // Create the feed item
        $items[] = [
            'id' => (string)$p->url(),
            'url' => (string)$p->url(),
            'title' => (string)$title,
            'content_html' => $content_html,
            'date_published' => (string)$p->date()->toDate(DATE_ATOM),
            'image' => $coverUrl
        ];
    }

    return [
        'items' => $items
    ];
};
