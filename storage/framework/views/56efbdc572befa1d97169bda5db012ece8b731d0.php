

<?php $__env->startSection('content'); ?>
    <?php if(count($frontpages) > 0): ?>
                <div class="panel panel-default">
                    <div class="panel-heading">
                        Temp User Page
                    </div>

                    <div class="panel-body">
                        <table class="table table-striped task-table">
                            <tbody>
                                <?php foreach($frontpages as $frontpages): ?>
                                    <tr>
                                        <div class="table table-bordered bg-success">
                                            <a href="<?php echo $frontpages->picture_link; ?>">
                                                <?php echo e($frontpages->picture_link); ?></a></div>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            <?php endif; ?>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>