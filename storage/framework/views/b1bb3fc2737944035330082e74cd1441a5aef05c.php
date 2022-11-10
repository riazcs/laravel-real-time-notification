

<?php $__env->startSection('content'); ?>
    <div class="col-xs-12 col-sm-12 col-md-8 col-lg-8 mr-auto ml-auto mt-5">
        <h3 class="text-center">
            Videos
        </h3>
        
        <?php $__currentLoopData = $videos; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $video): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <div class="col-md-8">
            <div class="card">
                <div class="card-header text-center">
                    <h5>Videos</h5>
                </div>

                <div class="card-body">
                    <video src="<?php echo e(asset($video->path)); ?>" controls="" style="width: 100%; height: auto"></video>
                </div>
            </div>
        </div>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH C:\xampp\htdocs\practise\laravel-real-time-notification\resources\views/video/videos.blade.php ENDPATH**/ ?>