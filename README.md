# jsonfeed-controller
Working on updating my site and converting what I had worked on for an XML RSS feed into a more current JSON feed within a Kirby CMS controller file.
https://github.com/getkirby

Since you're here you should browse the available elements in the  https://www.jsonfeed.org/version/1.1/ made by Manton Reese and Brent Simmons. Maybe there are a few elements you could add to this that I haven't. It looks much more flexible than the XML feed format. 

## Setup
I created a few files to make this work:
- `/site/templates/feed.json.php`
- `/site/blueprints/feed.json.yml`
- `/site/controllers/feed.json.php`
- `/content/feed/feed.json.txt`
  
## Edit these files
- /site/config/config.php

## Steps
This setup assumes several content folders of pages to round up for the Feed. 
1. In my case, I added a `Pages` field in the `/site/blueprints/site.yml`  file to choose what page in my site would be the RSS feed. This might seem extra, but it works for my needs.
2. Then in the second file above (`/site/blueprints/feed.json.yml`), I added a `Pages` field so I could select which content parents that have children I wanted to include in my feed. For example, I added `/content/articles/`, `/content/updates/`, `/content/nowplaying/` so that each of their children will get into the feed.
3. Let's sort the combined pages by date.
4. Next I added two additional textarea fields `rssblip` in that blueprint for the description of the feed, as well as the text I'd like to add at the end of each Feed item, encouraging readers to get in touch or reply via email, engage on Mastodon, what have you (alternatively you could just pipe in the SEO description of your site to the top of the feed as well if you like).
5. Then we move on to the template. The template is rather short, as you'll see. Unfortunately, creating the feed will end up being in the Controller mostly.
6. Next the controller file. This grabs the sections we want to include, sorts them, and grabs post images that use the typical Kirby `cover` image method but falls back to the first image available in each post.
7. Then the controller creates the $items array for the feed. This is an array of all of your site pages that will be included.
8. Then it takes the `cover` image and wraps it in a `figure`, adds `alt` text, a `figcaption` that allows links using the `->kirbytext()` powers, etc.
9. In the new `$content_html` object it first adds in the page's text content and strips out extra new lines code.
10. Then it adds the `cover` to the beginning of that new `$content_html`.
11. You can add in other field data you may have for your pages, here I have added `$materials` at the end, for a project I'm doing that I'll soon launch on the site.
12. It also adds in the `rssblip` at the end too, which has four `----` in the textarea to give it a divider from the item's content
13. I actually added in the title of each item's parent to differentiate it from other posts, too (i.e.: "Articles: ", "Updates: ", etc.)
14. Then it assembles the `$items` using the various objects we've created as well as fields from each page.
15. Returns the `$items` for use.
16. You'll see all of the data come together in the template.

If you have suggestions to make this better please fork it, change it, whatever you like. Cheers!

<img width="296" alt="image" src="https://github.com/luxuryluke/jsonfeed-controller/assets/57873/962cf208-2d94-461a-8632-26f22261b33c">


— Luke

