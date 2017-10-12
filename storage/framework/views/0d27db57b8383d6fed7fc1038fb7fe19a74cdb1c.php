<?php $__env->startSection('browser_subtitle', 'Admins'); ?>

<?php $__env->startSection('body'); ?>

    <div class="page-header">
        <div class="page-header-content">
            <div class="page-title"><h4>Admins Management</h4></div>

            <div class="heading-elements">
                <div class="heading-btn-group">
                    <a href="<?php echo e(url('admins/item')); ?>" class="btn btn-link btn-float has-text"><i class="icon-plus-circle2 text-primary"></i><span>Add New</span></a>
                </div>
            </div>
        </div>
    </div>

    <div class="content">

        <div class="row">
            <div class="col-md-12">

                <?php if(session('success')): ?>
                    <div class="alert alert-success" role="alert">
                        <button type="button" class="close" data-dismiss="alert">
                            <span>×</span><span class="sr-only">Close</span></button>
                        Saving operation completed successfully.
                    </div>
                <?php endif; ?>


                <div class="panel panel-flat">
                    <div class="table-responsive">
                        <table class="table table-hover table-striped">
                            <thead>
                            <tr>
                                <th>Name</th>
                                <th>Email</th>
                                <th></th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php $__empty_1 = true; foreach($items as $item): $__empty_1 = false; ?>
                                <tr>
                                    <td class="v-align-middle semi-bold"><?php echo e($item->name); ?></td>
                                    <td class="v-align-middle semi-bold"><?php echo e($item->email); ?></td>
                                    <td class="v-align-middle text-right text-nowrap">
                                        <a href="<?php echo e(url('admins/item/'.$item->id)); ?>" class="btn btn-primary btn-xs"><i class="icon-pencil5"></i></a>
                                        <a href="<?php echo e(url('admins/item/'.$item->id)); ?>" class="btn btn-danger btn-xs deleter"><i class="icon-trash"></i></a>
                                    </td>
                                </tr>
                            <?php endforeach; if ($__empty_1): ?>
                                <tr>
                                    <td colspan="41" class="text-center">No records were found.</td>
                                </tr>
                            <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>

            </div>
        </div>

    </div>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('common.base', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>