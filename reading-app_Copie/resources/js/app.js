import './bootstrap';
import 'preline';
import Alpine from 'alpinejs';
import { createIcons, icons } from 'lucide';
import bookManager from './components/bookManager';
import publicBookManager from './components/publicBookManager';

window.Alpine = Alpine;
Alpine.data('bookManager', bookManager);
Alpine.data('publicBookManager', publicBookManager);
Alpine.start();

window.lucide = { createIcons, icons };