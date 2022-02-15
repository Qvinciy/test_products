<template>
  <div>
    <div class="container m-auto grid grid-cols-4 gap-4">
       <div class="border-2 hover:border-blue-600 w-72 p-3 grid grid-cols-1 items-center" v-for="product in paginatedData">

           <div class="text-center">
               <img
                   class="p-4 max-w-full" :alt="product.name"
                   :src="product.image"
               />
           </div>

            <div class="uppercase font-bold text-center">
                {{product.name}}
            </div>

            <div class="text-blue-600 font-bold text-center mt-4 text-xl">
                $ {{product.price}}
            </div>

       </div>
    </div>
    <div class="container mb-12 text-4xl text-center m-auto grid grid-cols-2 gap-2" style="background:#f00" >

          <button class="border-4 grid grid-cols-1 focus:outline-none text-gray-900 hover:text-gray-100 font-bold"
              :disabled="pageNumber === 0"
              @click="prevPage">
              Previous
          </button>


          <button class="border-4 grid grid-cols-1 focus:outline-none text-gray-900 hover:text-gray-400 font-bold"
              :disabled="pageNumber >= pageCount -1"
              @click="nextPage">
              Next
          </button>

    </div>
 </div>
</template>

<script>
    export default{
      data(){
        return {
          pageNumber: 0
        }
      },
      props:{
        listData:{
          type:Array,
          required:true
        },
        size:{
          type:Number,
          required:false,
          default: 12
        }
      },
      methods:{
          nextPage(){
             this.pageNumber++;
          },
          prevPage(){
            this.pageNumber--;
          }
      },
      computed:{
        pageCount(){
          let l = this.listData.length,
              s = this.size;
          return Math.ceil(l/s);
        },
        paginatedData(){
          const start = this.pageNumber * this.size,
                end = start + this.size;
          return this.listData
                   .slice(start, end);
        }
      }
    }
</script>

<style>

</style>
