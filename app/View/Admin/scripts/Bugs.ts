/// <reference path="../../../../../../../public/static/bower_components/minute/_all.d.ts" />

module Admin {
    export class BugListController {
        constructor(public $scope:any, public $minute:any, public $ui:any, public $timeout:ng.ITimeoutService, public $http: any,
                    public gettext:angular.gettext.gettextFunction, public gettextCatalog:angular.gettext.gettextCatalog) {

            gettextCatalog.setCurrentLanguage($scope.session.lang || 'en');
            $scope.data = {selection: []};
        }

        actions = (item) => {
            let gettext = this.gettext;
            let actions = [
                {'text': gettext('View..'), 'icon': 'fa-search', 'hint': gettext('Edit bug'), 'href': '/admin/bugs/edit/' + item.bug_id},
                {'text': gettext('Remove'), 'icon': 'fa-trash', 'hint': gettext('Delete this bug'), 'click': 'item.removeConfirm("Removed")'},
            ];

            this.$ui.bottomSheet(actions, gettext('Actions for: ') + item.type, this.$scope, {item: item, ctrl: this});
        };

        clearSelection = () => {
            if (this.$scope.data.selection.length > 0) {
                this.$scope.bugs.removeConfirmAll(this.gettext('Removed'), null, null, null, this.$scope.data.selection);
            }
        };

        truncate = () => {
            this.$ui.confirm().then(() => {
                this.$http.post('/admin/bugs/truncate').then(() => this.$scope.bugs.splice(0, this.$scope.bugs.length));
            });
        };

        basename = (url) => url ? url.split(/[\/\\]/).pop() : '';
    }

    angular.module('bugListApp', ['MinuteFramework', 'AdminApp', 'gettext'])
        .controller('bugListController', ['$scope', '$minute', '$ui', '$timeout', '$http', 'gettext', 'gettextCatalog', BugListController]);
}
