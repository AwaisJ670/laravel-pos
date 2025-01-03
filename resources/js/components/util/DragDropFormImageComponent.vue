<template>
    <div
        :class="['container', {'p-0': (uploadedImage || image_path)}]"
        @dragover.prevent="dragOver"
        @dragleave.prevent="dragLeave"
        @drop.prevent="drop($event)"
    >
        <div class="drop" v-show="dropped == 2"></div>
        <div class="error" v-show="error">{{ error }}</div>
        <div class="beforeUploaded" v-if="!uploadedImage && !image_path">
            <input type="file" accept="image/*" @change="onChange" />
            <svg class="icon" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                <title>Upload Image</title>
                <g id="Upload_Image" data-name="Upload Image">
                <g id="_Group_" data-name="&lt;Group&gt;">
                    <g id="_Group_2" data-name="&lt;Group&gt;">
                    <g id="_Group_3" data-name="&lt;Group&gt;">
                        <circle
                        id="_Path_"
                        data-name="&lt;Path&gt;"
                        cx="18.5"
                        cy="16.5"
                        r="5"
                        style="
                            fill: none;
                            stroke: #303c42;
                            stroke-linecap: round;
                            stroke-linejoin: round;
                        "
                        />
                    </g>
                    <polyline
                        id="_Path_2"
                        data-name="&lt;Path&gt;"
                        points="16.5 15.5 18.5 13.5 20.5 15.5"
                        style="
                        fill: none;
                        stroke: #303c42;
                        stroke-linecap: round;
                        stroke-linejoin: round;
                        "
                    />
                    <line
                        id="_Path_3"
                        data-name="&lt;Path&gt;"
                        x1="18.5"
                        y1="13.5"
                        x2="18.5"
                        y2="19.5"
                        style="
                        fill: none;
                        stroke: #303c42;
                        stroke-linecap: round;
                        stroke-linejoin: round;
                        "
                    />
                    </g>
                    <g id="_Group_4" data-name="&lt;Group&gt;">
                    <polyline
                        id="_Path_4"
                        data-name="&lt;Path&gt;"
                        points="0.6 15.42 6 10.02 8.98 13"
                        style="
                        fill: none;
                        stroke: #303c42;
                        stroke-linecap: round;
                        stroke-linejoin: round;
                        "
                    />
                    <polyline
                        id="_Path_5"
                        data-name="&lt;Path&gt;"
                        points="17.16 11.68 12.5 7.02 7.77 11.79"
                        style="
                        fill: none;
                        stroke: #303c42;
                        stroke-linecap: round;
                        stroke-linejoin: round;
                        "
                    />
                    <circle
                        id="_Path_6"
                        data-name="&lt;Path&gt;"
                        cx="8"
                        cy="6.02"
                        r="1.5"
                        style="
                        fill: none;
                        stroke: #303c42;
                        stroke-linecap: round;
                        stroke-linejoin: round;
                        "
                    />
                    <path
                        id="_Path_7"
                        data-name="&lt;Path&gt;"
                        d="M19.5,11.6V4A1.5,1.5,0,0,0,18,2.5H2A1.5,1.5,0,0,0,.5,4V15A1.5,1.5,0,0,0,2,16.5H13.5"
                        style="
                        fill: none;
                        stroke: #303c42;
                        stroke-linecap: round;
                        stroke-linejoin: round;
                        "
                    />
                    </g>
                </g>
                </g>
            </svg>
            <p class="mainMessage">{{ upload_msg ? upload_msg : "Click to upload or drop your image here" }}</p>
        </div>
        <div class="imgPreview" v-else>
            <div class="imageHolder">
                <img :src="uploadedImage ? uploadedImage : image_path" />
                <span class="delete" style="color: white" @click="deleteImage">
                    <svg
                        class="icon"
                        xmlns="http://www.w3.org/2000/svg"
                        fill="none"
                        viewBox="0 0 24 24"
                        stroke="currentColor"
                    >
                        <path
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        stroke-width="2"
                        d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"
                        />
                    </svg>
                </span>
            </div>
        </div>
    </div>
</template>

<script>
export default {
    name: 'drag-drop-form-image-component',
    props: ['upload_msg', 'modal_type','image_path', 'id'],
    data() {
        return {
            uploadedImage: null,
            dropped: 0,
            error: null,
        }
    },
    methods: {
        dragOver() {
            this.dropped = 2;
        },
        dragLeave() {
        },
        drop(e) {
            e.stopPropagation();
            e.preventDefault();
            this.createFile(e.dataTransfer.files[0])
        },
        onChange(e) {
            this.createFile(e.target.files[0]);
        },
        createFile(file) {
            this.dropped = 0
            if (!file.type.match('image.*')) {
                this.error = 'Unsupported file type'
                this.uploadedImage = null
                return;
            }
            this.error = null;
            var image = new Image();
            var fileReader = new FileReader()
            let objVue = this;

            fileReader.onload = function (e) {
                objVue.uploadedImage = e.target.result;
            }
            fileReader.readAsDataURL(file);
            this.$emit('changed', {file: file, id: this.id})
        },
        deleteImage() {
            this.uploadedImage = null
            this.$emit('changed', {file: null, id: this.id})
        }
    },
}
</script>

<style scoped>
.container{
    width: 100%;
    height: 100%;
    background: #f7fafc;
    border: 0.5px solid #a3a8b1;
    border-radius: 10px;
    padding: 1rem;
    position: relative;
}
.drop{
    width: 100%;
    height: 100%;
    top: 0;
    border-radius: 10px;
    position: absolute;
    background-color: #f4f6ff;
    left: 0;
    border: 3px dashed #a3a8b1;
}
.error{
    position: absolute;
    color: red;
    font-size: .7rem;
    top: 1rem;
    left: 0;
    bottom: 0;
    right: 0;
    text-align: center;
}
.beforeUploaded{
    position: relative;
    text-align: center;
    margin: 1rem;
}
.beforeUploaded input{
    width: 100%;
    margin: auto;
    height: 100%;
    opacity: 0;
    position: absolute;
    background: red;
    display: block;
}
.beforeUploaded input:hover {
  cursor: pointer;
}
.beforeUploaded .icon {
  width: 2rem;
  margin: auto;
  display: block;
}
.beforeUploaded .mainMessage {
    margin: 0;
    font-size: .7rem;
}
.imgPreview .imageHolder{
    /* width: 160px;
    height: 135px;
    background: #fff;
    position: relative;
    border-radius: 10px;
    margin: 5px 5px;
    display: inline-block; */
    width: 100%;
    /* height: 100%; */
    background: #fff;
    position: relative;
    border-radius: 10px;
    /* margin: 5px 5px; */
    display: inline-block;
    padding: 10px;
}
.imgPreview .imageHolder img{
    object-fit: cover;
    width: 100%;
    height: 100%;
}
.imgPreview .imageHolder .delete {
    position: absolute;
    top: 4px;
    right: 4px;
    width: 29px;
    height: 29px;
    color: #fff;
    background: red;
    border-radius: 50%;
}
.imgPreview .imageHolder .delete:hover {
    cursor: pointer;
}

.imgPreview .imageHolder .delete .icon {
    width: 66%;
    height: 66%;
    display: block;
    margin: 4px auto;
}

</style>
