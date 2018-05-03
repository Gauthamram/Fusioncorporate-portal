<template>
	<div>
		<div class="form-group">
			<label>{{ label }}</label>
			<select class="form-control" v-model="selected" :name="name">
			    <option v-for="option in optionsObject" :value="option">{{option}}</option>
		    </select>
		</div>
	    <div v-for="option in optionsObject" class="form-group" :id="option" v-show="selected == option">
	        <label>{{ option }} *</label>
	        <input class="form-control" name="role_id" type="text">
	    </div>
	</div>
</template>
<script>
	export default {
		props: {
			options: { required:true },
			label: { required: true },
			name: { required: true }
		},
		data() {
	        return {
	            optionsObject: { },
	            selected: { }
	        }
	    },
		created() {
			this.optionsObject = JSON.parse(this.options);
		}
	}
</script>