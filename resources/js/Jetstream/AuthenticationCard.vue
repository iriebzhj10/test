<template>
<div class="container-fluid">
     <div class="row">
        <div class="col-md-10 ">
            <div >
                <slot />
            </div>
        </div>
        
         <div class="col-md-2">
            <div>
            <slot name="logo" />
            </div>
        </div>

    </div>
</div> 
  
   
</template>
