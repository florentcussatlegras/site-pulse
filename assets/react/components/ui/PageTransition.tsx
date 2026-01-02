// assets\react\components\ui\PageTransition.tsx

import { ReactNode, useEffect, useState } from 'react';

type Props = {
  children: ReactNode;
};

export default function PageTransition({ children }: Props) {
  const [visible, setVisible] = useState(false);

  useEffect(() => {
    setVisible(true);
  }, []);

  return (
    <div
      className={`
        w-full transition-all duration-500 ease-out
        ${visible ? 'opacity-100 translate-y-0' : 'opacity-0 translate-y-4'}
      `}
    >
      {children}
    </div>
  );
}
