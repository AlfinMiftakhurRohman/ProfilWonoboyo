// Shared interactions for Desa Wonoboyo site — vanilla, no deps.
(function(){
  function fmt(n){return Math.round(n).toLocaleString('id-ID');}
  function countUp(el){
    if(el._done)return; el._done=true;
    var t=parseFloat(el.dataset.target)||0, start=performance.now(), dur=1600;
    var dec=(el.dataset.dec?parseInt(el.dataset.dec):0);
    function fm(n){return dec?n.toFixed(dec):fmt(n);}
    function tick(now){var p=Math.min(1,(now-start)/dur),k=1-Math.pow(1-p,3);el.textContent=fm(t*k);if(p<1)requestAnimationFrame(tick);}
    requestAnimationFrame(tick);
  }
  function fillBar(el){
    if(el._done)return; el._done=true;
    el.style.width=(el.dataset.pct||0)+'%';
  }
  function init(){
    function check(){
      var h=window.innerHeight||document.documentElement.clientHeight;
      [].slice.call(document.querySelectorAll('.reveal')).forEach(function(el){var r=el.getBoundingClientRect();if(r.top<h*0.92&&r.bottom>0)el.classList.add('in');});
      [].slice.call(document.querySelectorAll('[data-target]')).forEach(function(el){var r=el.getBoundingClientRect();if(r.top<h*0.88&&r.bottom>0)countUp(el);});
      [].slice.call(document.querySelectorAll('.bar-fill')).forEach(function(el){var r=el.getBoundingClientRect();if(r.top<h*0.9&&r.bottom>0)fillBar(el);});
      document.querySelectorAll('.hero-media,.phero-media').forEach(function(m){var y=-m.getBoundingClientRect().top;if(y<h*1.4)m.style.transform='translateY('+(y*0.24)+'px)';});
      var nav=document.querySelector('.nav');
      var sy=window.scrollY||window.pageYOffset||0;
      if(nav)nav.classList.toggle('scrolled',sy>24);
    }
    check(); requestAnimationFrame(check);
    window.addEventListener('scroll',check,{passive:true});
    document.addEventListener('scroll',check,{passive:true,capture:true});
    window.addEventListener('resize',check);
    // poll briefly so DC content rendered after parse still animates in
    var n=0,iv=setInterval(function(){check();if(++n>24)clearInterval(iv);},160);
    setTimeout(function(){[].slice.call(document.querySelectorAll('.reveal')).forEach(function(el){el.classList.add('in');});[].slice.call(document.querySelectorAll('[data-target]')).forEach(countUp);[].slice.call(document.querySelectorAll('.bar-fill')).forEach(fillBar);},4200);

    // burger (delegated)
    document.addEventListener('click',function(e){
      var b=e.target.closest('.burger');
      if(b){var links=document.querySelector('.nav-links');if(links)links.classList.toggle('open');b.classList.toggle('active');return;}
      // close menu on link tap
      if(e.target.closest('.nav-links a')){var l=document.querySelector('.nav-links');var bb=document.querySelector('.burger');if(l)l.classList.remove('open');if(bb)bb.classList.remove('active');}
      // filter chips
      var f=e.target.closest('[data-filter]');
      if(f){
        var group=f.closest('.filterbar');
        var key=f.getAttribute('data-filter');
        if(group)group.querySelectorAll('[data-filter]').forEach(function(x){x.classList.toggle('active',x===f);});
        var scope=document.querySelector('[data-filter-scope]')||document;
        var items=scope.querySelectorAll('[data-cat]');
        var shown=0;
        items.forEach(function(it){
          var ok=(key==='all'||it.getAttribute('data-cat')===key);
          it.classList.toggle('hidden',!ok); if(ok)shown++;
        });
        var empty=scope.querySelector('[data-empty]');
        if(empty)empty.classList.toggle('hidden',shown>0);
        return;
      }
      // lightbox open
      var g=e.target.closest('[data-lightbox]');
      if(g){openLightbox(g);return;}
      // lightbox close
      if(e.target.closest('[data-lb-close]')||e.target.classList.contains('lightbox')){closeLightbox();}
    });
    document.addEventListener('keydown',function(e){if(e.key==='Escape')closeLightbox();});
  }
  function openLightbox(src){
    var lb=document.querySelector('.lightbox'); if(!lb)return;
    var inner=lb.querySelector('.lb-content');
    var cap=lb.querySelector('.lightbox-cap');
    var clone=src.querySelector('.card-img,.ph');
    inner.innerHTML='';
    if(clone){var c=clone.cloneNode(true);c.style.position='absolute';c.style.inset='0';c.style.transform='none';inner.appendChild(c);}
    if(cap)cap.textContent=src.getAttribute('data-cap')||'';
    lb.classList.add('open'); document.body.style.overflow='hidden';
  }
  function closeLightbox(){var lb=document.querySelector('.lightbox');if(lb){lb.classList.remove('open');document.body.style.overflow='';}}
  if(document.readyState==='loading')document.addEventListener('DOMContentLoaded',init);else init();
})();
