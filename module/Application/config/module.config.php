<?php

/**
 * @see       https://github.com/laminas/laminas-mvc-skeleton for the canonical source repository
 * @copyright https://github.com/laminas/laminas-mvc-skeleton/blob/master/COPYRIGHT.md
 * @license   https://github.com/laminas/laminas-mvc-skeleton/blob/master/LICENSE.md New BSD License
 */

declare(strict_types=1);

namespace Application;

use Laminas\Router\Http\Literal;
use Laminas\Router\Http\Segment;
use Laminas\ServiceManager\Factory\InvokableFactory;

return [
    'blog' => [
        'options' => [
            // The following indicate where to write files. Note that this
            // configuration writes to the "public/" directory, which would
            // create a blog made from static files. For the various
            // paginated views, "%d" is the current page number; "%s" is
            // typically a date string (see below for more information) or tag.

            'by_day_filename_template' => 'public/blog/day/%s-p%d.html',
            'by_month_filename_template' => 'public/blog/month/%s-p%d.html',
            'by_tag_filename_template' => 'public/blog/tag/%s-p%d.html',
            'by_year_filename_template' => 'public/blog/year/%s-p%d.html',
            'entries_filename_template' => 'public/blog/index-p%d.html',

            // In this case, the "%s" is the entry ID.
            'entry_filename_template' => 'public/blog/%s.html',

            // For feeds, the final "%s" is the feed type -- "atom" or "rss". In
            // the case of the tag feed, the initial "%s" is the current tag.
            'feed_filename' => 'public/blog/feed-%s.xml',
            'tag_feed_filename_template' => 'public/blog/tag/%s-%s.xml',

            // This is the link to a blog post
            'entry_link_template' => '/blog/%s.html',

            // These are the various URL templates for "paginated" views. The
            // "%d" in each is the current page number.
            'entries_url_template' => '/blog/index-p%d.html',
            // For the year/month/day paginated views, "%s" is a string
            // representing the date. By default, this will be "YYYY",
            // "YYYY/MM", and "YYYY/MM/DD", respectively.
            'by_year_url_template' => '/blog/year/%s-p%d.html',
            'by_month_url_template' => '/blog/month/%s-p%d.html',
            'by_day_url_template' => '/blog/day/%s-p%d.html',

            // These are the primary templates you will use -- the first is for
            // paginated lists of entries, the second for individual entries.
            // There are of course more templates, but these are the only ones
            // that will be directly referenced and rendered by the compiler.
            'entries_template' => 'blog/list',
            'entry_template' => 'blog/entry',

            // The feed author information is default information to use when
            // the author of a post is unknown, or is not an AuthorEntity
            // object (and hence does not contain this information).
            'feed_author_email' => 'vrkansagara@gmail.com',
            'feed_author_name' => 'Vallabh Kansagara (VRKANSAGARA)',
            'feed_author_uri' => 'https://vrkansagara.in/',
            'feed_hostname' => 'https://vrkansagara.in',
            'feed_title' => 'Blog Entries - Vallabh Kansagara(VRKANSAGARA) Blog',
            'tag_feed_title_template' => 'Tag: %s - Vallabh Kansagara(VRKANSAGARA) Blog',


            'author_feed_filename_template' => 'public/blog/author/%s-%s.xml',
            'author_feed_title_template' => 'Author: %s - Vallabh Kansagara(VRKANSAGARA) Blog',
            'by_author_filename_template' => 'public/blog/author/%s-p%d.html',

            // If generating a tag cloud, you can specify options for
            // Laminas\Tag\Cloud. The following sets up percentage sizing from
            // 80-300%
            'tag_cloud_options' => [
                'tagDecorator' => [
                    'decorator' => 'html_tag',
                    'options' => [
                        'fontSizeUnit' => '%',
                        'minFontSize' => 80,
                        'maxFontSize' => 300,
                    ],
                ]],
        ],
        // This is the location where you are keeping your post files (the PHP
        // files returning `PhlyBlog\EntryEntity` objects).
        'posts_path' => 'data/blog/',

        // You can provide your own callback to setup renderer and response
        // strategies. This is useful, for instance, for injecting your
        // rendered contents into a layout.
        // The callback will receive a View instance, application configuration
        // (as an array), and the application's Locator instance.
        'view_callback' => 'Application\Module::prepareCompilerView',

        // Tag cloud generation is possible, but you likely need to capture
        // the rendered cloud to inject elsewhere. You can do this with a
        // callback.
        // The callback will receive a Laminas\Tag\Cloud instance, the View
        // instance, application configuration // (as an array), and the
        // application's Locator instance.
        'cloud_callback' => ['Application\Module', 'handleTagCloud'],
    ],
    'router' => [
        'routes' => [
            'home' => [
                'type'    => Literal::class,
                'options' => [
                    'route'    => '/',
                    'defaults' => [
                        'controller' => Controller\IndexController::class,
                        'action'     => 'index',
                    ],
                ],
            ],
            'application' => [
                'type'    => Segment::class,
                'options' => [
                    'route'    => '/application[/:action]',
                    'defaults' => [
                        'controller' => Controller\IndexController::class,
                        'action'     => 'index',
                    ],
                ],
            ],
        ],
    ],
    'controllers' => [
        'factories' => [
            Controller\IndexController::class => InvokableFactory::class,
        ],
    ],
    'view_manager' => [
        'display_not_found_reason' => true,
        'display_exceptions'       => true,
        'doctype'                  => 'HTML5',
        'not_found_template'       => 'error/404',
        'exception_template'       => 'error/index',
        'template_map' => [
            'layout/layout'           => __DIR__ . '/../view/layout/layout.phtml',
            'application/index/index' => __DIR__ . '/../view/application/index/index.phtml',
            'error/404'               => __DIR__ . '/../view/error/404.phtml',
            'error/index'             => __DIR__ . '/../view/error/index.phtml',
        ],
        'template_path_stack' => [
            __DIR__ . '/../view',
        ],
    ],
];
