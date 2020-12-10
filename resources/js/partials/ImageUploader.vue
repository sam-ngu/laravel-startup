<!--Only 1 file allowed-->
<!--TODO: implement error mode (red border around v-img), if no image is selected-->
<template>

        <v-row align="center">

            <v-img
                v-if="states.showImage"
                :height="imgHeight"
                contain
                :src="imageUrl || undefined"
            >

                <div class="mx-auto text-center" :style="{
                    width: 'fit-content',
                    opacity: !!imageUrl ? 0.1 : 1,
                }">
                    <button-tooltip
                        :small="false"
                        :size="250"
                        tooltip="Upload a pic"
                        icon="mdi-camera"
                        @click="pickFile"
                    />
                    <div v-if="!value" v-text="'Insert an image'"></div>
                </div>

            </v-img>

            <!--<img :src="imageUrl" height="150" v-if="imageUrl"/>-->

            <!--<v-text-field label="Select Image" @click='pickFile' v-model='imageName' prepend-icon='attach_file'></v-text-field>-->

            <input
                type="file"
                style="display: none"
                ref="image"
                accept="image/*"
                @change="onFilePicked"
            >
        </v-row>

</template>

<script>
    import ButtonTooltip from "./ButtonTooltip";
    export default {
        name: "ImageUploader",
        components: {ButtonTooltip},
        data() {
            return {
                states: {
                    showImage: true,
                },
                imageUrl: "", //to temp store image data

                items: [],
                itemsAdded: '',
                itemsNames: [],
                itemsSizes: [],
                itemsTotalSize: '',
                formData: '',
            }
        },
        props: {
            value: "",  //img url or raw data
            imgHeight: {
                type: String,
                default: '300px'
            }
        },
        computed: {
        },
        methods: {

            // http://scratch99.com/web-development/javascript/convert-bytes-to-mb-kb/
            bytesToSize(bytes) {
                const sizes = ['Bytes', 'KB', 'MB', 'GB', 'TB'];
                if (bytes === 0) return 'n/a';
                let i = parseInt(Math.floor(Math.log(bytes) / Math.log(1024)));
                if (i === 0) return bytes + ' ' + sizes[i];
                return (bytes / Math.pow(1024, i)).toFixed(2) + ' ' + sizes[i];
            },

            pickFile () {
                this.$refs.image.click ()
            },
            onFilePicked (e) {

                this.formData = new FormData();
                let files = e.target.files || e.dataTransfer.files;
                console.log(files);
                let fileSizes = 0;
                for (let index in files) {
                    if (!isNaN(index)) {
                        this.items = e.target.files[index] || e.dataTransfer.files[index];
                        this.itemsNames[index] = files[index].name;
                        this.itemsSizes[index] = this.bytesToSize(files[index].size);
                        fileSizes += files[index].size;
                        this.formData.append('items[]', this.items);

                        let reader = new FileReader();

                        reader.onload = function(event){
                            this.imageUrl = event.target.result;
                            this.$emit('input', this.imageUrl)
                        }.bind(this);

                        reader.readAsDataURL(files[index]);

                    }
                }
                this.itemsTotalSize = this.bytesToSize(fileSizes);

                this.$emit('image-added', this.formData);
                this.$forceUpdate();

            },

            async hideImage(){
                this.states.showImage = false;
            },
            async showImage(){
                this.states.showImage = true;
            },

            // TODO: implement security filter in the future
            inputFilter(newFile, oldFile, prevent) {
                // https://github.com/lian-yue/vue-upload-component/blob/master/docs/views/examples/Full.vue

                if (newFile && !oldFile) {
                    // Before adding a file
                    // 添加文件前
                    // Filter system files or hide files
                    // 过滤系统文件 和隐藏文件
                    if (/(\/|^)(Thumbs\.db|desktop\.ini|\..+)$/.test(newFile.name)) {
                        return prevent()
                    }
                    // Filter php html js file
                    // 过滤 php html js 文件
                    if (/\.(php5?|html?|jsx?)$/i.test(newFile.name)) {
                        return prevent()
                    }
                    // Automatic compression
                    // 自动压缩
                    if (newFile.file && newFile.type.substr(0, 6) === 'image/' && this.autoCompress > 0 && this.autoCompress < newFile.size) {
                        newFile.error = 'compressing'
                        const imageCompressor = new ImageCompressor(null, {
                            convertSize: Infinity,
                            maxWidth: 512,
                            maxHeight: 512,
                        });
                        imageCompressor.compress(newFile.file)
                            .then((file) => {
                                this.$refs.upload.update(newFile, {error: '', file, size: file.size, type: file.type})
                            })
                            .catch((err) => {
                                this.$refs.upload.update(newFile, {error: err.message || 'compress'})
                            })
                    }
                }

                if (newFile && (!oldFile || newFile.file !== oldFile.file)) {
                    // Create a blob field
                    // 创建 blob 字段
                    newFile.blob = ''
                    let URL = window.URL || window.webkitURL
                    if (URL && URL.createObjectURL) {
                        newFile.blob = URL.createObjectURL(newFile.file)
                    }
                    // Thumbnails
                    // 缩略图
                    newFile.thumb = ''
                    if (newFile.blob && newFile.type.substr(0, 6) === 'image/') {
                        newFile.thumb = newFile.blob
                    }
                }
            }
        },
        mounted() {
            setTimeout( () => {
                // set imageurl at a later time otherwise it will be empty, as this component is mounted first
                this.imageUrl = this.value;
            }, 1000)

        },
    }
</script>

<style scoped>

</style>
