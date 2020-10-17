<template>
    <div>
        <img class="object-cover w-full"
             src="https://photographylife.com/wp-content/uploads/2017/01/What-is-landscape-photography.jpg"
             alt="user profile wallpaper" ref="userImage">

    </div>
</template>

<script>
import Dropzone from 'dropzone';

export default {
    name: "UploadableImage",
    props: [
        'imageWidth',
        'imageHeight',
        'location',
    ],
    data: () => {
        return {
            dropzone: null,
        }
    },
    mounted() {
        this.dropzone = new Dropzone(this.$refs.userImage, this.settings);
    },
    computed: {
        settings() {
            return {
                paramName: 'image',
                url: '/api/user-images',
                acceptedFiles: 'image/*',
                params: {
                    'width': this.imageWidth,
                    'height': this.imageHeight,
                    'location': this.location,
                },
                headers: {
                    'X-CSRF-TOKEN': document.head.querySelector('meta[name=csrf-token]').content,
                },
                success: (e, res) => {
                    alert('uploaded!');
                }
            }
        }
    }
}
</script>

<style scoped>

</style>
