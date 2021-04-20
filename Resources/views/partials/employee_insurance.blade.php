
<div class="clearfix"></div>
    <h4>Insurance Details</h4>
    <div class="col-md-6">
        <div class="insured form-group {{ $errors->has('insured') ? ' has-error' : '' }}">
            {!! Form::label('insured', 'Employee Has Insurance',['class'=>'control-label col-md-4']) !!}
            <div class="col-md-8">
                <label class="radio-inline">

                    <label class="radio-inline">
                        <input type="radio" value="0" name="insured" id="h_schemes" checked />
                        No
                    </label>

                    <label class="radio-inline">
                        <input type="radio" value="1" name="insured"  id="s_schemes"/>
                        Yes
                    </label>
            </div>
        </div>
    </div>
    <div class="clearfix"></div>
    <div id="schemes"  class="schemes hidden">
        <hr/>
        <!-- <button class="add_button btn btn-xs btn-primary"><i class="fa fa-plus-square-o"></i> Add Record</button> -->
        <div id="wrapper1">
            <div class="col-md-6">
                <div class="form-group {{ $errors->has('company') ? ' has-error' : '' }}">
                    {!! Form::label('company', 'Insurance Company',['class'=>'control-label col-md-4']) !!}
                    <div class="col-md-8">
                        {!! Form::select('company',get_insurance_companies(), null, ['class' => 'form-control company', 'placeholder' => 'Choose...']) !!}
                    </div>
                </div>
                <div class="form-group {{ $errors->has('scheme') ? ' has-error' : '' }}">
                    {!! Form::label('scheme', 'Insurance Schemes',['class'=>'control-label col-md-4']) !!}
                    <div class="col-md-8">
                        {!! Form::select('scheme',[], null, ['class' => 'form-control scheme', 'placeholder' => 'Choose...']) !!}
                    </div>
                </div>
                <div class="form-group {{ $errors->has('policy_number') ? ' has-error' : '' }}">
                    {!! Form::label('policy_number', 'Policy Number',['class'=>'control-label col-md-4']) !!}
                    <div class="col-md-8">
                        {!! Form::text('policy_number', null, ['class' => 'form-control', 'placeholder' => 'Policy Number']) !!}
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group {{ $errors->has('principal') ? ' has-error' : '' }}">
                    {!! Form::label('principal', 'Principal',['class'=>'control-label col-md-4']) !!}
                    <div class="col-md-8">
                        {!! Form::text('principal', null, ['class' => 'form-control', 'placeholder' => 'Principal Name']) !!}
                    </div>
                </div>
                <div class="form-group {{ $errors->has('principal_dob') ? ' has-error' : '' }}">
                    {!! Form::label('principal_dob', 'Date of Birth',['class'=>'date control-label col-md-4']) !!}
                    <div class="col-md-8">
                        {!! Form::text('principal_dob', null, ['class' => 'form-control date', 'placeholder' => 'Date of Birth']) !!}
                    </div>
                </div>
                <div class="form-group {{ $errors->has('principal_relationship') ? ' has-error' : '' }}">
                    {!! Form::label('principal_relationship', 'Relationship',['class'=>'control-label col-md-4']) !!}
                    <div class="col-md-8">
                        {!! Form::select('principal_relationship',mconfig('reception.options.relationship'), null, ['class' => 'form-control', 'placeholder' => 'Choose...']) !!}
                    </div>
                </div>
            </div>
        </div>
        <p class="text-muted">You can add more schemes for the user after saving.</p>
    </div>
<script type="text/javascript">
    var SCHEMES_URL = "{{route('api.settings.get_schemes')}}";
    $(document).ready(function () {
        $(".external_institution").select2();
    });
</script>
<script src="{{m_asset('reception:js/addpatient.min.js')}}"></script>

