'use strict';
var app = angular.module('sobApp', [
    'ngCookies',
    'ngResource',
    'ngSanitize',
    'pascalprecht.translate'
  ]);
app.config([
  '$routeProvider',
  function ($routeProvider) {
    $routeProvider.when('/', {
      templateUrl: 'views/main.html',
      controller: 'MainCtrl'
    }).when('/organizations/', { templateUrl: 'views/organizations.html' }).when('/organizations/:id', {
      templateUrl: 'views/organization.html',
      controller: 'OrgCtrl'
    }).when('/charts', { templateUrl: 'views/charts.html' }).when('/dictionary', { templateUrl: 'views/dictionary.html' }).otherwise({ redirectTo: '/' });
  }
]);
app.config([
  '$translateProvider',
  function ($translateProvider) {
    $translateProvider.translations('en', {
      SOCIAL_ON_BANKING: 'Social on Banking',
      TRUST_AND_ETHICS: 'Trust & Ethics in Finance',
      MORE_INFO: 'I would like further information about the project',
      FOLLOW_TWITTER: 'Follow to @SocialOnBanking',
      SOB_LANDING_P1: 'We are a new gateway to social banking, ethics, and sustainable.',
      SOB_LANDING_P2: 'We want to show you the different forms of social finance currently living in Spain applying three basic concepts: transparency, trust and cooperation.',
      SOB_LANDING_P3: 'Our goal is to be the way for citizens to choose the option of social banking that most interests them, with a clear and simple information.',
      TRANSPARENCY: 'Transparency',
      TRANSPARENCY_DESCRIPTION: 'We support a social banking in which transparency is one of its main features, and it is moved to the end user to know in detail where your money goes. It will also be a cornerstone for our project to guide its operation.',
      TRUST: 'Trust',
      TRUST_DESCRIPTION: 'The financial crisis has blown up the foundations of the current economic model, finding a system unable to create security for citizens. Social banking should lead change of the current model from the value of trust in their operation and its objectives.',
      COOPERATION: 'Cooperation',
      COOPERATION_DESCRIPTION: 'We intend to transmit to society the principles of social and ethical banking, and increase the number of people using it. For that reason we want to have all entities, citizens and businesses to attract the necessary tools for change.',
      SASKIA_QUOTE: 'The austerity is a resource transfer from citizens to banks.',
      WHO_WE_ARE: 'Who we are',
      LAUNCHED_BY: 'Project launched by ',
      ERIS: 'ERIS',
      KEEP_INFORMED: 'Keep you informed',
      FOLLOW_OUR: 'Follow our ',
      BLOG: 'blog',
      YOUR_OPINION_COUNTS: 'Your opinion counts',
      HELP_US: 'Help us by filling out this ',
      SURVEY: 'survey',
      CONTACT_US: 'Contact us'
    });
    $translateProvider.translations('es', {
      SOCIAL_ON_BANKING: 'Social on Banking',
      TRUST_AND_ETHICS: '\xc9tica y Confianza en las Finanzas',
      MORE_INFO: 'Deseo solicitar m\xe1s informaci\xf3n sobre el proyecto',
      FOLLOW_TWITTER: 'Follow to @SocialOnBanking',
      SOB_LANDING_P1: 'Somos una nueva pasarela a la banca social, \xe9tica, y sostenible.',
      SOB_LANDING_P2: 'Queremos presentar las diversas modalidades de finanzas sociales que conviven actualmente en Espa\xf1a aplicando tres conceptos fundamentales: transparencia, confianza y cooperaci\xf3n.',
      SOB_LANDING_P3: 'Nuestro objetivo es ser el medio para que los ciudadanos elijan la opci\xf3n de banca social que m\xe1s les interese, contando para ello con una informaci\xf3n clara y sencilla.',
      TRANSPARENCY: 'Transparencia',
      TRANSPARENCY_DESCRIPTION: 'Apostamos por una banca social en la que la transparencia sea una de sus principales caracter\xedsticas, y que \xe9sta se traslade al usuario final para que conozca al detalle d\xf3nde va su dinero. Adem\xe1s ser\xe1 un pilar fundamental para nuestro proyecto que guar\xe1 su funcionamiento.',
      TRUST: 'Confianza',
      TRUST_DESCRIPTION: 'La crisis financiera ha dinamitado los cimientos del modelo econ\xf3mico actual, descubriendo un sistema incapaz de generar seguridad para los ciudadanos. La banca social debe abanderar el cambio del modelo actual desde el valor de la confianza en su funcionamiento y en sus objetivos.',
      COOPERATION: 'Cooperaci\xf3n',
      COOPERATION_DESCRIPTION: 'Pretendemos transmitir a la sociedad los principios de la banca social y \xe9tica, adem\xe1s de incrementar el n\xfamero de usuarios de \xe9sta. Por ello queremos contar con todas las entidades, con la ciudadan\xeda y las empresas y generar as\xed las herramientas necesarias para el cambio.',
      SASKIA_QUOTE: 'La austeridad es una transferencia de recursos del ciudadano a los bancos.',
      WHO_WE_ARE: 'Qui\xe9nes somos',
      LAUNCHED_BY: 'Proyecto impulsado por ',
      ERIS: 'ERIS',
      KEEP_INFORMED: 'Mantenme informada',
      FOLLOW_OUR: 'S\xedguenos en nuestro ',
      BLOG: 'blog',
      YOUR_OPINION_COUNTS: 'Tu opini\xf3n cuenta',
      HELP_US: 'Ay\xfadanos rellenando esta ',
      SURVEY: 'encuesta',
      CONTACT_US: 'Cont\xe1ctanos'
    });
    $translateProvider.preferredLanguage('en');
  }
]);
'use strict';
angular.module('sobApp').controller('MainCtrl', [
  '$scope',
  '$translate',
  function ($scope, $translate) {
    $scope.changeLanguage = function (key) {
      $translate.use(key);
    };
  }
]);
'use strict';
angular.module('sobApp').controller('OrgCtrl', [
  '$scope',
  '$routeParams',
  function ($scope, $routeParams) {
    $scope.id = $routeParams.id;
  }
]);