<?php

/**
 * @see       https://github.com/laminas/laminas-mvc-skeleton for the canonical source repository
 * @copyright https://github.com/laminas/laminas-mvc-skeleton/blob/master/COPYRIGHT.md
 * @license   https://github.com/laminas/laminas-mvc-skeleton/blob/master/LICENSE.md New BSD License
 */

declare(strict_types=1);

namespace Application;

use Laminas\ModuleManager\Feature\ConfigProviderInterface;
use Laminas\View\Model\ViewModel;

class Module implements ConfigProviderInterface
{
    public function getConfig() : array
    {
        return include __DIR__ . '/../config/module.config.php';
    }

    public static function prepareCompilerView($view, $config, $services)
    {
        $renderer = $services->get('BlogRenderer');
        $view->addRenderingStrategy(function ($e) use ($renderer) {
            return $renderer;
        }, 100);

        $layout = new ViewModel();
        $layout->setTemplate('layout/layout');
        $view->addResponseStrategy(function ($e) use ($layout, $renderer) {
            $result = $e->getResult();
            $layout->setVariable('content', $result);
            $page = $renderer->render($layout);
            $e->setResult($page);

            // Cleanup
            $layout->setVariable('single', false);

            $headTitle = $renderer->plugin('headtitle');
            $headTitle->getContainer()->exchangeArray([]);
            $headTitle->append('VRKANSAGARA');
            $headTitle->setSeparator(' - ');
            $headTitle->setAutoEscape(false);

            $headLink = $renderer->plugin('headLink');
            $headLink->getContainer()->exchangeArray([]);
            $headLink([
                'rel' => 'shortcut icon',
                'type' => 'image/vnd.microsoft.icon',
                'href' => '/images/Application/favicon.ico',
            ]);

            $headScript = $renderer->plugin('headScript');
            $headScript->getContainer()->exchangeArray([]);

            $headMeta = $renderer->plugin('headMeta');
            $headMeta->getContainer()->exchangeArray([]);

            foreach (['sidebar', 'scripts'] as $name) {
                $placeholder = $renderer->placeholder($name);
                $placeholder->exchangeArray([]);
            }
        }, 100);
    }

}
