<template>
	<div class="row modal fade in" :style="styleObject">
		<div class="modal-dialog" role="document">
		    <div class="modal-content">
				<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close" @click="closeModal()"><span aria-hidden="true">&times;</span></button>
				<h4 class="modal-title" id="myModalLabel">Account Settings</h4>
				</div>
			    <form :action="recoveryUrl" method="post" id="recovery-form" @submit.prevent="submitForm()">
			      <div class="modal-body">
			            <div>
							<p v-show="alert.message" :class="'alert alert-' + alert.status">{{ alert.message}}</p>
						</div>
			            <div class="form-group">
			                <label>User Email</label>
			                    <input v-if="user" class="form-control"  readonly="true" name="email" type="email" v-model="form.email" placeholder="john.smith@mail.com">
			                    <input v-else lass="form-control" name="email" type="email" placeholder="john.smith@mail.com" required>
			                    <span class="text-danger" v-show="form.errors.get('email')">{{ form.errors.get('email')}}</span>
			            </div>
			      </div>
			      <div class="modal-footer">
			        <button id="recovery-submit" class="btn btn-primary">Recover Password</button>
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
	    data () {
			return {
				styleObject: {},
				form: new Form ({
					'email' : ''
				}),
				alert: {
				}
			}
		},
	    computed: {
	    	recoveryUrl() {
	            return "/user/recovery/"+ this.user.id;
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
		 methods: {
		 	submitForm() {
		 		this.form.post(this.$config.get('api.url') + 'auth/recovery')
		 			.then(response => this.setAlert(response.data))
		 	},
		 	closeModal() {
		 		this.setAlert({});
		 		this.$emit('close');
		 	},
		 	setAlert(data) {
		 		this.alert = data;
		 		this.form.email = this.user.email;
		 	},
		 },
		 mounted() {
		 	if (this.user.email){
		 		this.form.email = this.user.email
		 	}
		 }
	}
</script>
