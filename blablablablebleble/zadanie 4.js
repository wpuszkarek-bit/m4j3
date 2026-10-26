class EventEmitter {
  constructor() {
    this.events = {};
  }

  on(eventName, listener) {
    if (!this.events[eventName]) {
      this.events[eventName] = [];
    }
    this.events[eventName].push(listener);
    return this;
  }

  emit(eventName, ...args) {
    if (!this.events[eventName]) return false;
    
    const listeners = [...this.events[eventName]];
    listeners.forEach(listener => listener(...args));
    return true;
  }


  off(eventName, listener) {
    if (!this.events[eventName]) return this;

    this.events[eventName] = this.events[eventName].filter(
      registered => registered !== listener && registered.originalListener !== listener
    );
    
    return this;
  }

  once(eventName, listener) {
    const wrapper = (...args) => {
      this.off(eventName, wrapper);
      listener(...args);
    };

    wrapper.originalListener = listener;

    this.on(eventName, wrapper);
    return this;
  }
}