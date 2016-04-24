<?php $__env->startSection('content'); ?>
<div class="container-fluid">
    <div class="row">
        
    <div class="col-md-8 col-md-offset-2">
    <div class="panel panel-default">
    <div class="panel-heading">Login</div>
    <div class="panel-body">
                     
<?php if(count($errors) > 0): ?>
    <div class="alert alert-danger">
        <strong>Whoops!</strong> There were some problems with your input.<br><br>
        <ul>
            <?php foreach($errors->all() as $error): ?>
                <li><?php echo e($error); ?></li>
            <?php endforeach; ?>
        </ul>
    </div>
<?php endif; ?>

<form class="form-horizontal" role="form" method="POST" action="/login">
<input type="hidden" name="_token" value="<?php echo e(csrf_token()); ?>">

<div class="form-group">
<label class="col-md-4 control-label">Username</label>
<div class="col-md-6">
<input type="text" class="form-control" name="username" value="<?php echo e(old('username')); ?>">
</div>
</div>

<div class="form-group">
<label class="col-md-4 control-label">Password</label>
<div class="col-md-6">
<input type="password" class="form-control" name="password">
</div>
</div>

<div class="form-group">
<div class="col-md-6 col-md-offset-4">
<div class="checkbox">
<label>
<input type="checkbox" name="remember"> Remember Me
</label>
</div>
</div>
</div>

<div class="form-group">
    <div class="col-md-6 col-md-offset-4">
    <button type="submit" class="btn btn-primary" style="margin-right: 15px;">
        Login
    </button>

<a href="/password/email">Forgot Your Password?</a>
</div>
</div>
</form>
</div>
</div>
</div>

</div>
</div>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>