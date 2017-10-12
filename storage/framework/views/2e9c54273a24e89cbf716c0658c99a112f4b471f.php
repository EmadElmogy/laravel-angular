<?php $__env->startSection('browser_subtitle', 'Contacts'); ?>

<?php $__env->startSection('body'); ?>

    <div class="page-header">
        <div class="page-header-content">
            <div class="page-title"><h4>Contacts Management: <?php echo e($item->id ? $item->name : 'Add New'); ?></h4></div>
        </div>
    </div>

    <div class="content">

        <?php if(session('validationErrors')): ?>
            <div class="alert alert-danger" role="alert">
                <button class="close" data-dismiss="alert"></button>
                <?php echo e(session('validationErrors')); ?>

            </div>
        <?php endif; ?>

        <div class="panel panel-flat">
            <div class="panel-body">
                <form role="form" method="post" autocomplete="off" class="form-horizontal form-validate-jquery">
                    <?php echo e(csrf_field()); ?>



                    <fieldset class="content-group">
                        <div class="form-group">
                            <label class="control-label col-lg-2">Name</label>
                            <div class="col-lg-10">
                                <input type="text" class="form-control" required="required" name="name" value="<?php echo e($item->name ?: old('name')); ?>">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="control-label col-lg-2">Email</label>
                            <div class="col-lg-10">
                                <input type="email" class="form-control" required="required" name="email" value="<?php echo e($item->email ?: old('email')); ?>">
                            </div>
                        </div>
                    </fieldset>


                    <div class="text-right">
                        <button type="submit" class="btn btn-primary">Submit<i class="icon-arrow-right14 position-right"></i>
                        </button>
                    </div>
                </form>
            </div>
        </div>


    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('common.base', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>