/// <reference path="../../../../../../../../public/static/bower_components/minute/_all.d.ts" />
var Admin;
(function (Admin) {
    var BugEditController = (function () {
        function BugEditController($scope, $minute, $ui, $timeout, gettext, gettextCatalog) {
            var _this = this;
            this.$scope = $scope;
            this.$minute = $minute;
            this.$ui = $ui;
            this.$timeout = $timeout;
            this.gettext = gettext;
            this.gettextCatalog = gettextCatalog;
            this.basename = function (url) { return url ? url.split(/[\/\\]/).pop() : ''; };
            this.ignore = function (type) {
                var data = _this.$scope.config.data_json;
                data.errors = data.errors || {};
                data.errors.ignore = data.errors.ignore || [];
                if (data.errors.ignore.indexOf(type) === -1) {
                    data.errors.ignore.push(type);
                    _this.$scope.config.save().then(_this.save);
                }
            };
            this.save = function () {
                _this.$scope.bug.remove().then(function () { return top.location.href = '/admin/bugs'; });
            };
            gettextCatalog.setCurrentLanguage($scope.session.lang || 'en');
            $scope.bug = $scope.bugs[0];
            $scope.config = $scope.configs[0];
        }
        return BugEditController;
    }());
    Admin.BugEditController = BugEditController;
    angular.module('bugEditApp', ['MinuteFramework', 'AdminApp', 'gettext', 'ng.jsoneditor'])
        .controller('bugEditController', ['$scope', '$minute', '$ui', '$timeout', 'gettext', 'gettextCatalog', BugEditController]);
})(Admin || (Admin = {}));
