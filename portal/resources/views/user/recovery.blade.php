@extends('layout.popup')
@section('content')
<div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-label="Close" @click="showModal()"><span aria-hidden="true">&times;</span></button>
        <h4 class="modal-title" id="myModalLabel">Account Settings</h4>
      </div>
      <div class="modal-body">
        <form action="{{action('UserController@recovery')}}" method="post" id="recovery-form">
            <input name="_token" type="hidden" value="{{ csrf_token() }}"/>
            @if(isset($token))
                <input name="token" type="hidden" id="token" value="{{$token}}" />
            @endif
            <div class="form-group">
                <label>User Email</label>
                @if($users)
                    <input class="form-control"  readonly="readonly" name="email" type="email" value="{{$users['email']}}" placeholder="john.smith@mail.com" required>
                @else
                    <input class="form-control" name="email" type="email" placeholder="john.smith@mail.com" required>
                @endif
            </div>
      </div>
      <div class="modal-footer">
        <button type="submit" id="recovery-submit" class="btn btn-primary" v-on:click="submitForm()">Recover Password</button>
        </form>
      </div>
    </div>
</div>
@stop