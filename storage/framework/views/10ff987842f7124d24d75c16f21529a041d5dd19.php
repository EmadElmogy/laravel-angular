<?php $__env->startSection('browser_subtitle', 'Apartments'); ?>

<?php $__env->startSection('body'); ?>

    <div class="page-header">
        <div class="page-header-content">
            <div class="page-title"><h4>Apartments Management</h4></div>

            <div class="heading-elements">
                <div class="heading-btn-group">
                    <a href="<?php echo e(url('apartments/item')); ?>" class="btn btn-link btn-float has-text"><i class="icon-plus-circle2 text-primary"></i><span>Add New</span></a>
                </div>
            </div>
        </div>
    </div>

    <div class="content">

        <div class="row">
            <div class="col-md-12">

                <?php if(session('success')): ?>
                    <div class="alert alert-success" role="alert">
                        <button type="button" class="close" data-dismiss="alert"><span>×</span><span class="sr-only">Close</span></button>
                        Saving operation completed successfully.
                    </div>
                <?php endif; ?>


                <div class="row mb-20">
                    <form action="">
                        <div class="col-md-2">
                            <select name="filters[contact_id]" class="form-control select2">
                                <?php echo selectBoxOptionsBuilder([''=>'Contact Email']+\App\Contact::pluck('email','id')->toArray(), request('filters.contact_id')); ?>

                            </select>
                        </div>
                        <div class="col-md-2">
                            <button class="btn btn-info btn-sm">
                                <i class="icon-filter3 position-left"></i> Filter
                            </button>
                        </div>
                    </form>
                </div>

                <div class="panel panel-flat">
                    <div class="table-responsive">
                        <table class="table table-hover table-striped">
                            <thead>
                            <tr>
                                <th>Move In Date</th>
                                <th>Street</th>
                                <th>Postcode</th>
                                <th>Town</th>
                                <th>Country</th>
                                <th>Contact Email</th>
                                <th></th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php $__empty_1 = true; foreach($items as $item): $__empty_1 = false; ?>
                                <tr>
                                  <td class="v-align-middle semi-bold"><?php echo e($item->move_in_date); ?></td>
                                  <td class="v-align-middle semi-bold"><?php echo e($item->street); ?></td>
                                  <td class="v-align-middle semi-bold"><?php echo e($item->postcode); ?></td>
                                  <td class="v-align-middle semi-bold"><?php echo e($item->town); ?></td>
                                    <td class="v-align-middle semi-bold"><?php echo e($item->country); ?></td>
                                    <td class="v-align-middle semi-bold"><?php echo e($item->contact ? $item->contact->email : ''); ?></td>
                                    <td class="v-align-middle text-right text-nowrap">
                                        <a href="<?php echo e(url('apartments/item/'.$item->id)); ?>" class="btn btn-primary btn-xs"><i class="icon-pencil5"></i></a>
                                        <a href="<?php echo e(url('apartments/item/'.$item->id)); ?>" class="btn btn-danger btn-xs deleter"><i class="icon-trash"></i></a>
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