var config = {
    title: 'Меню',
    menu: {
        items: [
            {
                title: 'Список',
                url: 'extension.menu.list',
                items: []
            }
        ]
    }
};

angular.adminModule('menu', [
        'ui.router',
        'bincms.rest',
        'bincms.admin.menu.templates'
    ], config)
    .config(['$stateProvider', function ($stateProvider) {

        $stateProvider
            .state('extension.menu', {
                url: '/menu'
            })
            .state('extension.menu.list', {
                url: '/list',
                views: {
                    'content@layout': {
                        templateUrl: 'admin/menu/list.html',
                        controller: 'MenuListExtensionController'
                    }
                }
            })
            .state('extension.menu.create', {
                url: '/create',
                views: {
                    'content@layout': {
                        templateUrl: 'admin/menu/create.html',
                        controller: 'MenuCreateExtensionController'
                    }
                }
            })
            .state('extension.menu.update', {
                url: '/update/:id',
                views: {
                    'content@layout': {
                        templateUrl: 'admin/menu/update.html',
                        controller: 'MenuUpdateExtensionController',
                        resolve: {
                            menu: ['$menuService', '$stateParams', function (menuService, stateParams) {
                                return menuService.get({id: stateParams.id}).$promise;
                            }]
                        }
                    }
                }
            })
        ;
    }]);