'use strict';

var MenuUpdateExtensionController = BaseController.extend({

    init: function (scope, menuService, menu) {
        this.menuService = menuService;
        this.menu = menu;
        this._super(scope);
    },

    getDefaultSelected: function () {
        return {
            parent: null
        };
    },

    onSave: function (form, model) {

        if (form.validate()) {

            if (this.$scope.selected.parent !== null && angular.isDefined(this.$scope.selected.parent)) {
                model.parent = this.$scope.selected.parent.id;
            }

            this.menuService.update(
                {id: this.menu.id},
                model,
                this.saveSuccessCallback.bind(this),
                this.saveErrorCallback.bind(this, form)
            );
        }
    },

    saveSuccessCallback: function () {
    },

    saveErrorCallback: function (form, result) {
        form.setErrors(result.data.errors);
    },

    getParents: function (text) {
        return this.menuService.query({text: text, text_comparison: 'endswith', direct: false}).$promise;
    },

    onSelectedUrl: function (url) {

        this.$scope.menuModel.url = url;
    },

    defineListeners: function () {
        this._super();
    },

    defineScope: function () {
        this._super();
        this.$scope.onSave = this.onSave.bind(this);
        this.$scope.onSelectedUrl = this.onSelectedUrl.bind(this);
        this.$scope.getParents = this.getParents.bind(this);
        this.$scope.selected = this.getDefaultSelected();
        this.$scope.menuModel = this.menu;
        this.$scope.selected.parent = this.menu.parent;
    },

    destroy: function () {
    }
});

MenuUpdateExtensionController.$inject = [
    '$scope', '$menuService', 'menu'
];

angular.adminModule('menu').controller('MenuUpdateExtensionController', MenuUpdateExtensionController);