/// <reference path="../../../../../../../public/static/bower_components/minute/_all.d.ts" />
var Admin;
(function (Admin) {
    var BugListController = (function () {
        function BugListController($scope, $minute, $ui, $timeout, $http, gettext, gettextCatalog) {
            var _this = this;
            this.$scope = $scope;
            this.$minute = $minute;
            this.$ui = $ui;
            this.$timeout = $timeout;
            this.$http = $http;
            this.gettext = gettext;
            this.gettextCatalog = gettextCatalog;
            this.actions = function (item) {
                var gettext = _this.gettext;
                var actions = [
                    { 'text': gettext('View..'), 'icon': 'fa-search', 'hint': gettext('Edit bug'), 'href': '/admin/bugs/edit/' + item.bug_id },
                    { 'text': gettext('Remove'), 'icon': 'fa-trash', 'hint': gettext('Delete this bug'), 'click': 'item.removeConfirm("Removed")' },
                ];
                _this.$ui.bottomSheet(actions, gettext('Actions for: ') + item.type, _this.$scope, { item: item, ctrl: _this });
            };
            this.clearSelection = function () {
                if (_this.$scope.data.selection.length > 0) {
                    _this.$scope.bugs.removeConfirmAll(_this.gettext('Removed'), null, null, null, _this.$scope.data.selection);
                }
            };
            this.truncate = function () {
                _this.$ui.confirm().then(function () {
                    _this.$http.post('/admin/bugs/truncate').then(function () { return _this.$scope.bugs.splice(0, _this.$scope.bugs.length); });
                });
            };
            this.basename = function (url) { return url ? url.split(/[\/\\]/).pop() : ''; };
            gettextCatalog.setCurrentLanguage($scope.session.lang || 'en');
            $scope.data = { selection: [] };
        }
        return BugListController;
    }());
    Admin.BugListController = BugListController;
    angular.module('bugListApp', ['MinuteFramework', 'AdminApp', 'gettext'])
        .controller('bugListController', ['$scope', '$minute', '$ui', '$timeout', '$http', 'gettext', 'gettextCatalog', BugListController]);
})(Admin || (Admin = {}));
