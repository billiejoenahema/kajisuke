<template>
  <Qalendar
    :selected-date="new Date(2022, 0, 8)"
    :events="events"
    :config="config"
  />
</template>

<script>
import { Qalendar } from 'qalendar';

export default {
  components: {
    Qalendar,
  },

  data() {
    return {
      events: [
        {
          title: 'Meeting with Dora',
          with: 'Albert Einstein',
          time: { start: '2022-01-01 04:52', end: '2022-01-01 05:37' },
          color: 'green',
          isEditable: true,
          id: 'de471c78cb5c',
          description:
            "Think of me as Yoda. Only instead of being little and green, I wear suites and I'm awesome.",
        },
        {
          title: 'Advanced algebra',
          with: 'Pheobe Buffay',
          time: { start: '2022-01-02 20:05', end: '2022-01-02 21:35' },
          colorScheme: 'sports',
          isEditable: true,
          id: '6d3c0980a5cf',
          description:
            'Lorem ipsum dolor sit amet, consectetur adipisicing elit. Asperiores assumenda corporis doloremque et expedita molestias necessitatibus quam quas temporibus veritatis. Deserunt excepturi illum nobis perferendis praesentium repudiandae saepe sapiente voluptatem!',
        },
        {
          title: 'Break',
          with: 'Marshall Eriksen',
          time: { start: '2022-01-02 22:10', end: '2022-01-02 22:55' },
          colorScheme: 'meetings',
          isEditable: true,
          id: '9f1b209982f1',
          location: 'Zoom',
        },
        // ... and more
      ],

      config: {
        locale: 'zh-CN',
        defaultMode: 'month',
        style: {
          colorSchemes: {
            meetings: {
              color: '#fff',
              backgroundColor: '#131313',
            },
            sports: {
              color: '#fff',
              backgroundColor: '#ff4081',
            },
          },
        },
      },
    };
  },
};
</script>
