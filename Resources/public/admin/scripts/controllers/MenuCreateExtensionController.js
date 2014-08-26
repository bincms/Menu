'use strict';

var MenuCreateExtensionController = BaseController.extend({

    init: function (scope, menuService, urlService) {
        this.menuService = menuService;
        this.urlService = urlService;

        this._super(scope);
    },

    getDefaultCategoryModel: function () {
        return {
            title: '',
            url: '',
            position: 0,
            alias: '',
            parent: null
        };
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

            this.menuService.save(
                model,
                this.saveSuccessCallback.bind(this),
                this.saveErrorCallback.bind(this, form)
            );
        }
    },

    saveSuccessCallback: function () {
        this.resetForm();
    },

    saveErrorCallback: function (form, result) {
        form.setErrors(result.data.errors);
    },

    getParents: function (text) {
        return this.menuService.query({text: text, text_comparison: 'endswith', direct: false}).$promise;
    },

    resetForm: function () {
        this.$scope.menuModel = this.getDefaultCategoryModel();
        this.$scope.selected = this.getDefaultSelected();
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
        this.$scope.menuModel = this.getDefaultCategoryModel();
        this.$scope.selected = this.getDefaultSelected();
    },

    destroy: function () {
    }
});

MenuCreateExtensionController.$inject = [
    '$scope', '$menuService'
];

angular.adminModule('menu').controller('MenuCreateExtensionController', MenuCreateExtensionController);
