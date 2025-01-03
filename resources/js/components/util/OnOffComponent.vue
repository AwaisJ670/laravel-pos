<template>
    <div>
        <toggle-button
            @change="updateStatus"
            :value="checked"
            color="#800080"
        >
        </toggle-button>
    </div>

</template>

<script>
export default {
    name: "on-off-component",
    props:[
        'is_active'
    ],
    data(){
        return {
            checked: this.is_active
        }
    },
    methods: {
        updateStatus(){
            if(this.checked){
                this.checked = false;
            } else{
                this.checked = true;
            }
            // this.updateUserStatus();
        },
        updateUserStatus(){
            this.loading = true
            axios({
                url: '/app-users/is-active/status/update/' + this.id,
                method: 'POST',
                data: {is_active: this.checked},
                config: {headers: {'content-type': 'multipart/form-data; boundary=${form._boundary}'}},
                responseType: 'json'
            }).then((response) => {
                    if (response.status === 200) {
                        this.loading = false
                        this.$emit('getResponseMessage', 'message', response.data.message)
                    }
                }
            ).catch(error => {
                if (error.response.status === 500){
                    this.$emit('getResponseMessage', 'error', error.response.statusText)
                }
            });
        }
    }
}
</script>

<style scoped>

</style>
