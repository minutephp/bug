<div class="content-wrapper ng-cloak" ng-app="bugEditApp" ng-controller="bugEditController as mainCtrl" ng-init="init()">
    <div class="admin-content" minute-hot-keys="{'ctrl+s':mainCtrl.save}">
        <section class="content-header">
            <h1><span translate="">View bug details</span></h1>

            <ol class="breadcrumb">
                <li><a href="" ng-href="/admin"><i class="fa fa-dashboard"></i> <span translate="">Admin</span></a></li>
                <li><a href="" ng-href="/admin/bugs"><i class="fa fa-bug"></i> <span translate="">Bugs</span></a></li>
                <li class="active"><i class="fa fa-edit"></i> <span translate="">View bug #{{bug.bug_id}}</span></li>
            </ol>
        </section>

        <section class="content">
            <form name="bugForm" ng-submit="mainCtrl.save()">
                <div class="box box-{{bugForm.$valid && 'success' || 'danger'}}">
                    <div class="box-body">
                        <div class="form-group">
                            <label class="control-label"><span translate="">File:</span></label>
                            <div>{{bug.file}}:{{bug.line}}</div>
                        </div>

                        <div class="form-group">
                            <label class="control-label"><span translate="">Error message:</span></label>
                            <div>{{bug.message}}</div>
                        </div>

                        <div class="form-group">
                            <label class="control-label">{{mainCtrl.basename(bug.file)}} <span translate="">(error snapshot):</span></label>
                            <div class="panel panel-default">
                                <div ng-repeat="(line, code) in bug.snapshot_json">
                                    <pre class="plain {{+line == bug.line && 'alert alert-danger' || ''}}">{{+line + 1}}. {{code}}</pre>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="control-label"><span translate="">Request data:</span></label>
                            <div>
                                <div ng-jsoneditor options="{modes: ['tree', 'code'], name: type}" ng-model="bug.data_json" style="height:250px;"></div>
                            </div>
                        </div>
                    </div>

                    <div class="box-footer with-border">
                        <div class="form-group">
                            <button type="submit" class="btn btn-flat btn-success pull-left" ng-click=""><i class="fa fa-check"></i> <span translate="">This bug has been resolved</span></button>
                            <button type="button" class="btn btn-flat btn-default pull-right" ng-click="mainCtrl.ignore(bug.type)">
                                <i class="fa fa-eye-slash"></i> <span translate="">Always Ignore </span>{{bug.type}}
                            </button>
                        </div>
                    </div>
                </div>
            </form>
        </section>
    </div>
</div>
