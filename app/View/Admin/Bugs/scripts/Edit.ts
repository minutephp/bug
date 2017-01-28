/// <reference path="../../../../../../../../public/static/bower_components/minute/_all.d.ts" />

module Admin {
    export class BugEditController {
        constructor(public $scope:any, public $minute:any, public $ui:any, public $timeout:ng.ITimeoutService,
                    public gettext:angular.gettext.gettextFunction, public gettextCatalog:angular.gettext.gettextCatalog) {

            gettextCatalog.setCurrentLanguage($scope.session.lang || 'en');
            $scope.bug = $scope.bugs[0];
            $scope.config = $scope.configs[0];
        }

        basename = (url) => url ? url.split(/[\/\\]/).pop() : '';

        ignore = (type) => {
            let data = this.$scope.config.data_json;
            data.errors = data.errors || {};
            data.errors.ignore = data.errors.ignore || [];

            if (data.errors.ignore.indexOf(type) === -1) {
                data.errors.ignore.push(type);
                this.$scope.config.save().then(this.save);
            }
        };

        save = () => {
            this.$scope.bug.remove().then(() => top.location.href = '/admin/bugs');
        };
    }

    angular.module('bugEditApp', ['MinuteFramework', 'AdminApp', 'gettext', 'ng.jsoneditor'])
        .controller('bugEditController', ['$scope', '$minute', '$ui', '$timeout', 'gettext', 'gettextCatalog', BugEditController]);
}
