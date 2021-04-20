<?php
/**
 * Created by PhpStorm.
 * User: bravo
 * Date: 8/18/17
 * Time: 2:57 PM
 */
 try{
     $clinics = \GuzzleHttp\json_decode($user->profile->clinics);
 }catch (\Exception $e){
     $clinics = null;
 }
?>
<style>
    h3  {
        border-bottom: 1px solid #eee;
    }
</style>
<div class="box-body">
    <div class="row">
        <div class="col-md-12">
            <div class="col-md-12">
                <h3>Set Clinics User Can Log in to</h3>
            </div>
            <div class="clearfix"></div>
            <div class="permissionGroup">
                <div class="col-md-8">
                    <p class="pull-right" style="margin-top: 10px;">
                        <a href="" class="jsSelectAllInGroup">Allow all</a> |
                        <a href="" class="jsDeselectAllInGroup">Deny all</a>
                    </p>
                </div>
                <div class="clearfix"></div>
                <div class="col-md-3">
                    <?php foreach (get_clinics() as $key=>$value): ?>
                    <input type="hidden" name="user_id" value="{{$user->id}}">
                    <div class="checkbox">
                        <label for="<?php echo "$value" ?>">
                            <input value="<?php echo "$key" ?>" id="<?php echo "$key" ?>" name="clinics[]" type="checkbox" class="flat-blue"
                            <?php
                            if(is_array($clinics)){
                                echo in_array($key, $clinics)?'checked':'';
                            }
                            ?> value="true" />
                            {{ ucfirst($value) }}
                        </label>
                    </div>
                    <?php endforeach; ?>
                </div>
                <div class="clearfix"></div>
            </div>
        </div>
    </div>
</div>
<script src="{{m_asset('users:js/role.min.js')}}"></script>
