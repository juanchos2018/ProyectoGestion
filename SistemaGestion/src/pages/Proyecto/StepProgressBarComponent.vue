<template>
  <div class="step-progress-bar container mt-4">
    <div class="container row">
        <div class="col">
            <div class="progress">
                <div class="progress-bar" role="progressbar" aria-valuenow="0"   aria-valuemin="0" aria-valuemax="100">
                    <div v-for="i in totalSteps" v-bind:key="i"
                         v-bind:ref="'step-circle-' + i"
                         v-bind:class="['step-circle', 'not-started-step-circle']"
                         v-bind:style="{left: ((i-1) * 100/(totalSteps-1)) + '%'}"
                         
                    >
                         {{i}}
                         <br>
                        
                    </div>
                </div>
            </div>
        </div>
    </div>
    <h4 ref="stepTitleRef" class="step-title-header mt-4 text-center font-weight-bold mx-auto"></h4>
</div>
</template>
  <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
<script>

export default {
  name: 'stepProgressBar',
  props: ['totalSteps', 'initCurrentStep', 'stepTitles'],
  data () {
    return {
        currentStep: this.initCurrentStep
    }
  },
  methods: {
     ver(){
         alert("ver")
     },
    changeCurrentStep: function(newStep) {
        if (newStep < 0) {
            this.currentStep = 0;
        } else if (newStep > (this.totalSteps + 1)) {
            this.currentStep = this.totalSteps + 1;
        } else {
            this.currentStep = newStep;
        }
    },
    updateProgressBar: function() {
        var totalCompletedSteps = this.currentStep > this.totalSteps ? this.totalSteps : (this.currentStep <= 0 ? 0 : (this.currentStep - 1));
        
        for(var i = 1; i <= this.totalSteps; i++) {
            var stepCircleElement = this.$refs['step-circle-' + i][0];
            if (i == this.currentStep) {
                stepCircleElement.classList.add("current-step-circle");
                stepCircleElement.classList.remove("completed-step-circle");
                stepCircleElement.classList.remove("not-started-step-circle");
            } else if ( i <= totalCompletedSteps) {
                stepCircleElement.classList.add("completed-step-circle");
                stepCircleElement.classList.remove("current-step-circle");
                stepCircleElement.classList.remove("not-started-step-circle");
            } else {
                stepCircleElement.classList.add("not-started-step-circle");
                stepCircleElement.classList.remove("completed-step-circle");
                stepCircleElement.classList.remove("current-step-circle");
            }
        }
        var propgressBarInPercent = totalCompletedSteps == this.totalSteps ? 100 : (totalCompletedSteps*100/(this.totalSteps - 1));
        $('.progress-bar').css('width', propgressBarInPercent + '%');
        var stepTitle = this.stepTitles[this.currentStep - 1];
        this.$refs.stepTitleRef.innerHTML = stepTitle == undefined ? "" : stepTitle;
    }
  },
  mounted() {
    this.$nextTick(function() {
       this.updateProgressBar();
    });
  },
  watch: {
    currentStep: function() {
        this.updateProgressBar();
    }
  }
}
</script>

<style lang="scss">
.step-progress-bar .progress {
  height: 10px;
  position: relative;
  overflow: visible;
  background-color: #aaa;
}
.step-progress-bar .progress-bar {
    background-color: #3aac5d;
}
.step-progress-bar .step-circle {
    border-style: solid;
    border-width: 3px;
    background: #ffffff;
    position: absolute;
    display: table-cell;
    height: 36px;
    width: 36px;
    text-align: center;
    vertical-align: middle;
    border-radius: 50%;
    font: 18px "josefin sans", arial;
    text-align: center;
    margin-top: 0px;
    padding-top: 5px; 
    margin-left: -5px; 
}
.step-progress-bar .current-step-circle {
    color: #3aac5d;
    background-color: #fff;
    border-color: #3aac5d;
}
.step-progress-bar .completed-step-circle {
    color: #fff;
    background-color:#3aac5d;
    border-color: #3aac5d;
}
.step-progress-bar .not-started-step-circle {
    color: #aaa;
    background-color: #fff;
    border-color: #aaa;
}
.step-title-header {
    font-family: Arial, Helvetica, sans-serif;
    color: #003366;
}
</style>
