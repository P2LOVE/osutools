var anim;
var animdata = {
  container: document.getElementById('animation'),
  renderer: 'svg',
  loop: false,
  autoplay: true,
  path: '/js/preloader.json'
  }
anim = bodymovin.loadAnimation(animdata);      
        
    document.body.onload = function(){
        if((anim.playSpeed > 0.05)){
        setInterval(function(){
            if ((anim.playSpeed > 0.05)){
            anim.setSpeed(anim.playSpeed - 0.05);        
            }
            if ((anim.playSpeed > 0.2)){
            anim.setSpeed(anim.playSpeed - 0.01);        
            }
        }, 450);}
    }
    

