<template>
	<div class="row modal fade in" :style="styleObject">
		<div class="modal-dialog" role="document">
		    <div class="modal-content">
				<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close" @click="$emit('close')"><span aria-hidden="true">&times;</span></button>
				<h4 class="modal-title" id="myModalLabel">Account Settings</h4>
				</div>
			    <form action="recoveryUrl()" method="post" id="recovery-form">
			      <div class="modal-body">
			            <!-- <input name="_token" type="hidden" value="{{ csrf_token() }}"/> -->
			           <!--  @if(isset($token))
			                <input name="token" type="hidden" id="token" value="{{$token}}" />
			            @endif -->
			            <div class="form-group">
			                <label>User Email</label>
			                    <input v-if="user" class="form-control"  readonly="readonly" name="email" type="email" :value="user.email" placeholder="john.smith@mail.com" required>
			                    <input v-else lass="form-control" name="email" type="email" placeholder="john.smith@mail.com" required>
			            </div>
			      </div>
			      <div class="modal-footer">
			        <button type="submit" id="recovery-submit" class="btn btn-primary" v-on:click="submitForm()">Recover Password</button>
			      </div>
			    </form>
		    </div>
		</div>
	</div>
</template>
<script>
	export default {
		props: {
	        user: { required: true },
	        show: { required: true }
	    },
	    computed: {
	    	recoveryUrl() {
	            return "/user/recovery/"+ this.user.id;
	        }
	    },
	    data () {
			return {
				styleObject: {
    			}
			}
		},
		watch: {
		    show: function (newShow, oldShow) {
		    	if (newShow == true ) {
		    		this.styleObject = { display: 'block' };
		    	} else {
		    		this.styleObject = { display: 'none' };
		    	}
		    }
		  },
	}
</script>
