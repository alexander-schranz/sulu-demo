import { startApp } from 'sulu-headless-bundle';
import viewRegistry from 'sulu-headless-bundle/src/registries/viewRegistry';
import HeadlessTemplatePage from './views/HeadlessTemplatePage';

// register views for rendering page templates
viewRegistry.add('page', 'homepage', HeadlessTemplatePage);
viewRegistry.add('page', 'overview', HeadlessTemplatePage);
viewRegistry.add('page', 'default', HeadlessTemplatePage);

// register views for rendering article templates
// viewRegistry.add('article', 'headless-template', HeadlessTemplateArticle);

// start react application in specific DOM element
startApp(document.getElementById('sulu-headless-container'));
