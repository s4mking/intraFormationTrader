var tabs = function(id) {
  this.el = document.getElementById(id);

  this.tab = {
    el: '.tab',
    list: null
  }

  this.nav = {
    el: '.tab-nav',
    list: null
  }

  this.pag = {
    el: '.tab-pag',
    list: null
  }

  this.count = null;
  this.selected = 0;

  this.init = function() {
    // Create tabs
    this.tab.list = this.createTabList();
    this.count = this.tab.list.length;

    // Create nav
    this.nav.list = this.createNavList();
    this.renderNavList();

    // Create pag
    this.pag.list = this.createPagList();
    //this.renderPagList();

    // Set selected
    tabs = document.querySelectorAll(".container .tab")
    tabs[0].classList.add("selected");
    this.setSelected(this.selected);

  }

  this.createTabList = function() {
    var list = [];

    this.el.querySelectorAll(this.tab.el).forEach(function(el, i) {
      list[i] = el;
    });

    return list;
  }

  this.createNavList = function() {
    var list = [];

    this.tab.list.forEach(function(el, i) {
      var listitem = document.createElement('a');
      listitem.className = 'nav-item',
        listitem.innerHTML = el.getAttribute('data-name'),
        listitem.onclick = function() {
          this.setSelected(i);
          return false;
        }.bind(this);

      list[i] = listitem;
    }.bind(this));

    return list;
  }

  this.createPagList = function() {
    var list = [];

    list.prev = document.createElement('a');
    list.prev.className = 'pag-item pag-item-prev',
      list.prev.onclick = function() {
        this.setSelected(this.selected - 1);
        return false;
      }.bind(this);

    list.next = document.createElement('a');
    list.next.className = 'pag-item pag-item-next',
      list.next.onclick = function() {
        this.setSelected(this.selected + 1);
        return false;
      }.bind(this);

    list.submit = document.createElement('button');
    list.submit.className = 'pag-item pag-item-submit';

    return list;
  }

  this.renderNavList = function() {
    var nav = document.querySelector(this.nav.el);

    this.nav.list.forEach(function(el) {
      nav.appendChild(el);
    });
  }

  this.renderPagList = function() {
    var pag = document.querySelector(this.pag.el);

    pag.appendChild(this.pag.list.prev);
    pag.appendChild(this.pag.list.next);
    pag.appendChild(this.pag.list.submit);
  }

  this.setSelected = function(target) {
    var min = 0,
      max = this.count - 1;

    if(target > max || target < min) {
      return;
    }

    if(target == min) {
      this.pag.list.prev.classList.add('hidden');
    } else {
      this.pag.list.prev.classList.remove('hidden');
    }

    if(target == max) {
      this.pag.list.next.classList.add('hidden');
      this.pag.list.submit.classList.remove('hidden');
    } else {
      this.pag.list.next.classList.remove('hidden');
      this.pag.list.submit.classList.add('hidden');
    }

    this.tab.list[this.selected].classList.remove('selected');
    this.tab.list[this.selected].querySelector('input').value='';
    this.nav.list[this.selected].classList.remove('selected');
    this.selected = target;
    this.tab.list[this.selected].classList.add('selected');
    this.nav.list[this.selected].classList.add('selected');
  }
};

var tabbedForm = new tabs('tabbedForm');
tabbedForm.init();
document.addEventListener('DOMContentLoaded', function() {
  const tabs = document.querySelectorAll('.tab-nav .nav-item');
  const tabContents = document.querySelectorAll('.tab');

  tabs.forEach(tab => {
    tab.addEventListener('click', function() {
      tabs.forEach(item => item.classList.remove('selected'));
      tabContents.forEach(content => content.classList.remove('selected'));

      this.classList.add('selected');
      document.querySelector(`.tab[data-name="${this.textContent.trim()}"]`).classList.add('selected');
    });
  });

  // Set the first tab as active by default
  tabs[0].classList.add('selected');
  tabContents[0].classList.add('selected');
});
