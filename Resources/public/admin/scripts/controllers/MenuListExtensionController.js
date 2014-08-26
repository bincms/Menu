'use strict';

var MenuListExtensionController = BaseController.extend({

    init: function (scope, menuService, locationService) {
        this.menuService = menuService;
        this.locationService = locationService;
        this.searchData = locationService.search();
        this._super(scope);
    },

    onLoadChildClick: function (parentId) {
        this.loadChild(parentId);
    },

    loadChild: function (parentId) {
        if (null === parentId) {
            var menus = this.menuService.query(function () {
                if (menus.length > 0) {
                    this.$scope.breadcrumb = [];
                    this.$scope.menus = menus;
                    this.locationService.search('parentId', null);
                }
            }.bind(this));
        } else {
            var menu = this.menuService.get({id: parentId, is_detailed: true}, function () {
                if (menu.children.length > 0) {
                    this.$scope.menus = menu.children;
                    this.$scope.breadcrumb = menu.paths;
                    this.locationService.search('parentId', parentId);
                }
            }.bind(this));
        }
    },

    onRemoveClick: function (menu) {
        this.menuService.delete(
            {id: menu.id},
            this.onRemoveSuccessCallback.bind(this, menu)
        );
    },

    onRemoveSuccessCallback: function (menu) {
        angular.removeItemWithArray(this.$scope.menus, false, menu);
    },

    defineListeners: function () {
        this._super();
    },

    /**
     * Use this function to define all scope objects.
     * Give a way to instantaly view whats available
     * publicly on the scope.
     */
    defineScope: function () {
        this._super();
        this.$scope.onLoadChildClick = this.onLoadChildClick.bind(this);
        this.$scope.onRemoveClick = this.onRemoveClick.bind(this);

        var parentId = this.searchData.parentId || null;
        this.loadChild(parentId);
    }
});

MenuListExtensionController.$inject = [
    '$scope', '$menuService', '$location'
];

angular.adminModule('menu').controller('MenuListExtensionController', MenuListExtensionController);