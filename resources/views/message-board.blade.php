@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">
                Bateeq
                </div>
                <div class="panel-body">
                    <div class="form-group">
                    <center>Message Board</center>
                    <br/>
                        <label for="message" class="col-md-2 control-label">Message</label>

                        <div class="col-md-8">
                            <TEXTAREA id="prjDescription" class="form-control"></TEXTAREA> 
                        </div>
                    </div>
                    <br/><br/><br/>
                    <div class="form-group">
                        <div class="col-md-8 col-md-offset-6">
                            <button type="submit" class="btn btn-primary">
                                Save
                            </button>
                             <button type="cancel" class="btn btn-primary">
                                Cancel
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection