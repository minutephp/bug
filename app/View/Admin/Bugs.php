<div class="content-wrapper ng-cloak" ng-app="bugListApp" ng-controller="bugListController as mainCtrl" ng-init="init()">
    <div class="admin-content">
        <section class="content-header">
            <h1><span translate="">List of bugs</span> <small><span translate="">(unresolved bugs)</span></small></h1>

            <ol class="breadcrumb">
                <li><a href="" ng-href="/admin"><i class="fa fa-dashboard"></i> <span translate="">Admin</span></a></li>
                <li class="active"><i class="fa fa-bug"></i> <span translate="">Bug list</span></li>
            </ol>
        </section>

        <section class="content">
            <div class="box box-default">
                <div class="box-header with-border">
                    <h3 class="box-title">
                        {{bugs.getTotalItems() || 'No'}} <span translate="">unresolved bugs</span>
                    </h3>

                    <div class="box-tools">
                        <button class="btn btn-xs btn-default btn-flat" ng-click="mainCtrl.truncate()">
                            <i class="fa fa-warning"></i> <span translate="">Clear all bugs</span>
                        </button>
                    </div>
                </div>

                <div class="box-body">
                    <div class="padded-left" ng-show="!!bugs.length">
                        <div class="pull-left">
                            <div class="checkbox"><label><input type="checkbox" minute-checkbox-all on="bugs" selection="data.selection"> <span translate="">Select all</span></label></div>
                        </div>
                        <div class="pull-right">
                            <button type="button" class="btn btn-flat btn-default btn-xs" ng-click="mainCtrl.clearSelection()" ng-show="!!data.selection.length">
                                <i class="fa fa-trash"></i> <span translate="">Remove selected</span>
                            </button>
                        </div>
                        <div class="clearfix"></div>
                    </div>

                    <div class="list-group">
                        <div class="list-group-item list-group-item-bar list-group-item-bar-{{bug.resolved && 'success' || 'danger'}}"
                             ng-repeat="bug in bugs" ng-click-container="mainCtrl.actions(bug)">
                            <div class="pull-left">
                                <h4 class="list-group-item-heading">
                                    <input type="checkbox" ng-model="bug.selected" title="select">
                                    <b>{{bug.type | ucfirst}}:</b> {{bug.message | truncate: 70 : '..' | ucfirst}} ({{(bug.severity || 'error') | ucfirst}})
                                </h4>
                                <p class="list-group-item-text hidden-xs">
                                    <span translate="">Last seen:</span> {{bug.created_at | timeAgo}}.
                                    <span translate="">Count:</span> {{bug.occurrence || 1}} <span translate="">times</span>.
                                    <span translate="">File:</span> {{mainCtrl.basename(bug.file)}}#{{bug.line}}
                                </p>
                            </div>
                            <div class="md-actions pull-right">
                                <a class="btn btn-default btn-flat btn-sm" ng-href="/admin/bugs/edit/{{bug.bug_id}}">
                                    <i class="fa fa-search"></i> <span translate="">View..</span>
                                </a>
                            </div>

                            <div class="clearfix"></div>
                        </div>
                    </div>
                </div>

                <div class="box-footer">
                    <div class="row">
                        <div class="col-xs-12 col-md-6 col-md-push-6">
                            <minute-pager class="pull-right" on="bugs" no-results="{{'No bugs found' | translate}}"></minute-pager>
                        </div>
                        <div class="col-xs-12 col-md-6 col-md-pull-6">
                            <minute-search-bar on="bugs" columns="message, type" label="{{'Search bugs..' | translate}}"></minute-search-bar>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
</div>
