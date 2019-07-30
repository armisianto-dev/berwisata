import {
  animate,
  animateChild,
  group,
  query as q,
  style,
  transition,
  trigger,
} from '@angular/animations'
const query = (s, a, o = { optional: true }) => q(s, a, o)

export const routerTransition = trigger('routerTransition', [
  transition('* => catalogue-detail', [
    query(':enter, :leave', style({ position: 'fixed', width: '100%' }), {
      optional: true,
    }),
    group([
      query(
        ':leave',
        [
          style({ transform: 'translateY(-100%)', opacity: '0' }),
          animate('1s ease-in-out', style({ transform: 'translateY(0%)' })),
        ],
        { optional: true }
      ),
      query(
        ':enter',
        [
          style({ transform: 'translateY(0%)' }),
          animate('1s ease-in-out', style({ transform: 'translateY(100%)' })),
        ],
        { optional: true }
      ),
    ]),
    query(':enter', animateChild()),
  ]),
  transition('catalogue-detail => catalogue', [
    query(':leave, :enter', style({ position: 'fixed', width: '100%' }), {
      optional: true,
    }),
    group([
      query(
        ':enter',
        [
          style({ transform: 'translateX(-100%)' }),
          animate('1s ease-in-out', style({ transform: 'translateX(0%)' })),
        ],
        { optional: true }
      ),
      query(
        ':leave',
        [
          style({ transform: 'translateX(0%)', opacity: '0' }),
          animate('1s ease-in-out', style({ transform: 'translateX(100%)' })),
        ],
        { optional: true }
      ),
    ]),
    query(':enter', animateChild()),
  ]),
  transition('* => *', [
    query(':enter, :leave', style({ position: 'fixed', width: '100%' }), {
      optional: true,
    }),
    group([
      query(
        ':enter',
        [
          style({ transform: 'translateY(-100%)' }),
          animate('1s ease-in-out', style({ transform: 'translateY(0%)' })),
        ],
        { optional: true }
      ),
      query(
        ':leave',
        [
          style({ transform: 'translateY(0%)', opacity: '0' }),
          animate('1s ease-in-out', style({ transform: 'translateY(100%)' })),
        ],
        { optional: true }
      ),
    ]),
    query(':enter', animateChild()),
  ]),
])
